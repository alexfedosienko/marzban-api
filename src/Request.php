<?php

namespace AlexFedosienko;

class Request
{
    protected string $host;
    protected array $headers = [];
    protected $client = null;

    /**
     * @throws \Exception
     *
     * @return $this
     */
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
     * @param string $host
     *
     * @return $this
     */
    public function setHost(string $host): Request
    {
        $this->host = $host;
        return $this;
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function setHeaders(array $headers): Request
    {
        $this->headers = array_merge($this->headers, $headers);
        return $this;
    }

    public function setHeader(string $key, string $value): Request
    {
        $this->headers[$key] = $value;
        return $this;
    }

    public function getHeaders(): array
    {
        $h = [];
        foreach ($this->headers as $k => $v) {
            $h[] = $k . ':' . $v;
        }

        return $h;
    }

    public function getHeader(string $key): string
    {
        return $this->headers[$key];
    }

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

    public function post(string $url, array $query = [], array $payload = [], bool $isJson = false): Response
    {
        curl_setopt_array($this->client, [
            CURLOPT_URL => $this->getHost() . $url . $this->getQuery($query),
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => $this->getHeaders(),
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $isJson ? json_encode($payload) : $payload,
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

    // public function put()
    // {
    //     //
    // }

    // public function patch()
    // {
    //     //
    // }

    // public function delete()
    // {
    //     //
    // }

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
