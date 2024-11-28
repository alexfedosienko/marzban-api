<?php

namespace AlexFedosienko\MarzbanAPI;

use AlexFedosienko\MarzbanAPI\Request;
use AlexFedosienko\MarzbanAPI\Response;
use AlexFedosienko\MarzbanAPI\Traits\HostEndpoints;
use AlexFedosienko\MarzbanAPI\Traits\NodeEndpoints;
use AlexFedosienko\MarzbanAPI\Traits\UserEndpoints;
use AlexFedosienko\MarzbanAPI\Exceptions\NotFoundException;
use AlexFedosienko\MarzbanAPI\Exceptions\AuthorizationException;
use AlexFedosienko\MarzbanAPI\Exceptions\EmptyParameterException;
use AlexFedosienko\MarzbanAPI\Exceptions\UserAlreadyExistsException;

class Marzban implements MarzbanInterface
{
    use UserEndpoints,
        NodeEndpoints,
        HostEndpoints;

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

    /**
     * getRequest
     *
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->client;
    }

    /**
     * auth
     *
     * @throw AuthorizationException
     * @throw NotFoundException
     * @throw UserAlreadyExistsException
     * @throw EmptyParameterException
     * @return void
     */
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

    /**
     * checkExceptions
     *
     * @param  Response $response
     * @throw AuthorizationException
     * @throw NotFoundException
     * @throw UserAlreadyExistsException
     * @throw EmptyParameterException
     * @return void
     */
    protected function checkExceptions(Response $response): void
    {
        $body = $response->getBody();


        // Ошибка авторизации
        if ($response->getStatusCode() == 401) {
            throw new AuthorizationException($body['detail'], $response->getStatusCode());
        }

        if ($response->getStatusCode() == 404) {
            throw new NotFoundException($body['detail']);
        }

        if (isset($body['detail'])) {
            if (is_string($body['detail'])) {

                // Create new user
                if ($response->getStatusCode() == 409) {
                    throw new UserAlreadyExistsException($body['detail']);
                }

                // Get user by username
                throw new EmptyParameterException($body['detail']);
            }

            if (is_string($body['detail']['body'])) {
                throw new EmptyParameterException($body['detail']['body']);
            }
        }
    }
}
