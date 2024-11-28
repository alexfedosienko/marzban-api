<?php

namespace AlexFedosienko\MarzbanAPI;

class Response
{

    protected $curl;
    protected $response;

    public function __construct($response, $curl)
    {
        $this->curl = $curl;
        $this->response = $response;
    }

    /**
     * isJson
     *
     * @return Bool
     */
    public function isJson(): Bool
    {
        return curl_getinfo($this->curl, CURLINFO_CONTENT_TYPE) == 'application/json';
    }

    /**
     * getBody
     *
     * @return string|array
     */
    public function getBody(): string|array
    {
        if ($this->isJson()) {
            return json_decode($this->response, true);
        }
        return $this->response;
    }

    /**
     * getStatusCode
     *
     * @return int
     */
    public function getStatusCode(): int
    {
        return curl_getinfo($this->curl, CURLINFO_HTTP_CODE);
    }
}
