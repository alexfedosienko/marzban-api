<?php

namespace AlexFedosienko\MarzbanAPI;

class Request
{
    protected string $host;
    protected array $headers = [];
    protected $client = null;

    public function __construct()
    {
        $this->client = curl_init();

        if (!$this->client) {
            throw new \Exception('Curl isn\'t install');
        }

        curl_setopt_array($this->client, [
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
        ]);
    }

    /**
     * setHost
     *
     * @param  string $host
     * @return Request
     */
    public function setHost(string $host): Request
    {
        $this->host = $host;
        return $this;
    }

    /**
     * getHost
     *
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * setHeaders
     *
     * @param  array $headers
     * @return Request
     */
    public function setHeaders(array $headers): Request
    {
        $this->headers = array_merge($this->headers, $headers);
        return $this;
    }

    /**
     * setHeader
     *
     * @param  string $key
     * @param  string $value
     * @return Request
     */
    public function setHeader(string $key, string $value): Request
    {
        $this->headers[$key] = $value;
        return $this;
    }

    /**
     * getHeaders
     *
     * @return array
     */
    public function getHeaders(): array
    {
        $h = [];
        foreach ($this->headers as $k => $v) {
            $h[] = $k . ': ' . $v;
        }

        return $h;
    }

    /**
     * getHeader
     *
     * @param  string $key
     * @return string
     */
    public function getHeader(string $key): string
    {
        return $this->headers[$key];
    }

    /**
     * get
     *
     * @param  string $url
     * @param  array $query
     * @return Response
     */
    public function get(string $url, array $query = []): Response
    {
        curl_setopt_array($this->client, [
            CURLOPT_URL => $this->getHost() . $url . $this->getQuery($query),
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => $this->getHeaders(),
        ]);

        $response = $this->exec();

        return new Response($response, $this->client);
    }

    /**
     * post
     *
     * @param  string $url
     * @param  array $query
     * @param  array $payload
     * @param  bool $isJson
     * @return Response
     */
    public function post(string $url, array $query = [], array $payload = [], bool $isJson = false): Response
    {
        if ($isJson) {
            $payload = json_encode($payload);
            $this->setHeader('Content-Type', 'application/json');
        }

        curl_setopt_array($this->client, [
            CURLOPT_URL => $this->getHost() . $url . $this->getQuery($query),
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => $this->getHeaders(),
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $payload,
        ]);

        $response = $this->exec();

        return new Response($response, $this->client);
    }

    protected function exec()
    {
        $result = curl_exec($this->client);

        if ($result === false) {
            throw new \Exception(curl_error($this->client));
        }

        return $result;
    }

    /**
     * put
     *
     * @param  string $url
     * @param  array $query
     * @param  array $payload
     * @param  bool $isJson
     * @return Response
     */
    public function put(string $url, array $query = [], array $payload = [], bool $isJson = false): Response
    {
        if ($isJson) {
            $payload = json_encode($payload);
            $this->setHeader('Content-Type', 'application/json');
        }

        curl_setopt_array($this->client, [
            CURLOPT_URL => $this->getHost() . $url . $this->getQuery($query),
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_HTTPHEADER => $this->getHeaders(),
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $payload,
        ]);

        $response = $this->exec();

        return new Response($response, $this->client);
    }

    // public function patch()
    // {
    //     //
    // }

    /**
     * delete
     *
     * @param  string $url
     * @param  array $query
     * @return Response
     */
    public function delete(string $url, array $query = []): Response
    {
        curl_setopt_array($this->client, [
            CURLOPT_URL => $this->getHost() . $url . $this->getQuery($query),
            CURLOPT_CUSTOMREQUEST => 'DELETE',
            CURLOPT_HTTPHEADER => $this->getHeaders(),
        ]);

        $response = $this->exec();

        return new Response($response, $this->client);
    }

    /**
     * getQuery
     *
     * @param  array $query
     * @return string
     */
    protected function getQuery(array $query = []): string
    {
        if (sizeof($query) > 0) return '?' . http_build_query($query);
        return '';
    }

    public function __destruct()
    {
        curl_close($this->client);
    }
}
