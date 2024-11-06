<?php

namespace AlexFedosienko;

use AlexFedosienko\Response;
use AlexFedosienko\Traits\UserEndpoints;
use AlexFedosienko\Exceptions\AuthorizationException;
use AlexFedosienko\Exceptions\EmptyParameterException;

class Marzban
{
    use UserEndpoints;

    protected Request $client;
    protected string $username;
    protected string $password;

    public function __construct(string $host, string $username, string $password)
    {
        $this->client = new Request();
        $this->client->setHost($host);

        if (empty($username)) throw new EmptyParameterException('Username is empty');
        $this->username = $username;

        if (empty($password)) throw new EmptyParameterException('Password is empty');
        $this->password = $password;

        $this->auth();
    }

    public function getRequest(): Request
    {
        return $this->client;
    }

    protected function auth(): void
    {
        $response = $this->getRequest()->post('/api/admin/token', [], [
            'username' => $this->username,
            'password' => $this->password,
        ]);

        $this->checkExceptions($response);

        if (!isset($response->getBody()['access_token'])) {
            throw new AuthorizationException();
        }

        $this->getRequest()->setHeader('Authorization', 'Bearer ' . $response->getBody()['access_token']);
    }

    protected function checkExceptions(Response $response)
    {
        $body = $response->getBody();

        if ($response->getStatusCode() == 401) {
            throw new AuthorizationException($body['detail'], $response->getStatusCode());
        }

        if (isset($body['detail'])) {
            if (is_string($body['detail'])) {
                throw new AuthorizationException($body['detail']);
            }
        }
    }

    // class Marzban implements MarzbanInterface
    // {
    //     protected $url = '';
    //     protected $username = '';
    //     protected $password = '';
    //     protected $curl;

    //     protected $headers = [
    //         'Cache-Control: no-cache',
    //         'Accept: application/json',
    //     ];

    //     public function __construct($url, $username, $password)
    //     {
    //         $this->url = $url;
    //         $this->username = $username;
    //         $this->password = $password;

    //         $this->curl = \curl_init();
    //         if (!$this->curl) throw new \Exception('Curl isn\'t install');

    //         curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, true);
    //         curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
    //         curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, false);

    //         // $this->auth();
    //     }

    //     public function getUser(string $username): User
    //     {
    //         $response = $this->get('/api/user/' . $username);
    //         $user = User::fromMarzban($response);
    //         return $user;
    //     }

    //     public function createUser(string $username, string $secret, int $dataLimit = 0, int $expire = 0): User
    //     {
    //         $payload = [
    //             'username' => $username,
    //             'proxies' => [
    //                 'vless' => [
    //                     'id' => $secret,
    //                 ]
    //             ],
    //             'inbounds' => [
    //                 'vless' => [
    //                     'VLESS TCP REALITY',
    //                 ]
    //             ],
    //         ];
    //         if ($dataLimit > 0) $payload['data_limit'] = $dataLimit;
    //         if ($expire > 0) $payload['expire'] = $expire;

    //         $response = $this->post('/api/user', [], $payload);

    //         return User::fromMarzban($response);
    //     }

    //     public function deleteUser(string $username)
    //     {
    //         $this->delete('/api/user/' . $username);
    //     }

    //     public function getNodes(): array
    //     {
    //         $response = $this->get('/api/nodes/');
    //         return array_map(fn($item) => Node::fromMarzban($item), $response);
    //     }

    //     public function getHosts(): array
    //     {
    //         $response = $this->get('/api/hosts/');
    //         return array_map(fn($item) => Host::fromMarzban($item), $response);
    //         return [];
    //     }

    //     public function getServerUri(): string
    //     {
    //         return $this->url;
    //     }

    //     public function auth(): void
    //     {
    //         $payload = [
    //             'username' => $this->username,
    //             'password' => $this->password,
    //         ];

    //         curl_setopt($this->curl, CURLOPT_URL, $this->getUrl('/api/admin/token'));
    //         curl_setopt($this->curl, CURLOPT_HTTPHEADER, $this->getRequestHeaders());
    //         curl_setopt($this->curl, CURLOPT_POST, true);
    //         curl_setopt($this->curl, CURLOPT_POSTFIELDS, $payload);
    //         $response = curl_exec($this->curl);
    //         $response = json_decode($response, true);

    //         if (!isset($response['access_token'])) {
    //             throw new AuthenticationException();
    //         }

    //         $this->headers[] = 'Authorization: Bearer ' . $response['access_token'];
    //     }

    //     protected function get(string $url, array $params = [])
    //     {
    //         curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'GET');
    //         curl_setopt($this->curl, CURLOPT_URL, $this->getUrl($url, $params));
    //         curl_setopt($this->curl, CURLOPT_HTTPHEADER, $this->getRequestHeaders());

    //         $response = curl_exec($this->curl);
    //         $response = json_decode($response, true);

    //         $this->checkExceptions($url, $response, curl_getinfo($this->curl, CURLINFO_HTTP_CODE));

    //         return $response;
    //     }

    //     protected function post(string $url, array $params = [], ?array $payload = null)
    //     {
    //         $headers = $this->getRequestHeaders([
    //             'Content-Type: application/json'
    //         ]);
    //         curl_setopt($this->curl, CURLOPT_URL, $this->getUrl($url, $params));
    //         curl_setopt($this->curl, CURLOPT_HTTPHEADER, $headers);
    //         curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'POST');
    //         curl_setopt($this->curl, CURLOPT_POST, true);
    //         curl_setopt($this->curl, CURLOPT_POSTFIELDS, json_encode($payload));
    //         $response = curl_exec($this->curl);
    //         $response = json_decode($response, true);
    //         $this->checkExceptions($url, $response, curl_getinfo($this->curl, CURLINFO_HTTP_CODE));
    //         return $response;
    //     }

    //     protected function delete(string $url, array $params = [])
    //     {
    //         $headers = $this->getRequestHeaders([
    //             'Content-Type: application/json'
    //         ]);
    //         curl_setopt($this->curl, CURLOPT_URL, $this->getUrl($url, $params));
    //         curl_setopt($this->curl, CURLOPT_HTTPHEADER, $headers);
    //         curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
    //         $response = curl_exec($this->curl);
    //         $response = json_decode($response, true);
    //         $this->checkExceptions($url, $response, curl_getinfo($this->curl, CURLINFO_HTTP_CODE));
    //         return $response;
    //     }

    //     protected function checkExceptions($url = '', $response = [], $statusCode = 200)
    //     {
    //         if ($statusCode == 401) {
    //             throw new AuthenticationException($response['detail']);
    //         }

    //         if ($statusCode == 404) {
    //             throw new NotFoundException($url);
    //         }

    //         if (isset($response['detail'])) {
    //             if (is_string($response['detail'])) {
    //                 throw new ValidationException($response['detail']);
    //             }
    //             if (is_array($response['detail'])) {
    //                 throw new ValidationException(implode(',', $response['detail']));
    //             }
    //         }
    //     }

    //     protected function getUrl(string $uri, array $params = []): string
    //     {
    //         return $this->getServerUri() . $uri . (sizeof($params) > 0 ? '?' . http_build_query($params) : '');
    //     }

    //     protected function getRequestHeaders(array $headers = []): array
    //     {
    //         return array_merge($this->headers, $headers);
    //     }

    //     public function __destruct()
    //     {
    //         curl_close($this->curl);
    //     }
    // }


}
