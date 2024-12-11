<?php

namespace AlexFedosienko\MarzbanAPI\Models\Hosts;

use AlexFedosienko\MarzbanAPI\Models\Host;

class VMessWebsocket extends Host
{
    /**
     * make
     *
     * @param  array $hostJson
     * @return Host
     */
    public static function make(array $hostJson): Host
    {
        throw new \Exception('Not implemented');
    }

    /**
     * toUrl
     *
     * @param  string $secret
     * @param  string $afterRemark
     * @param  array $params
     *
     * @return string
     */
    public function toUrl(string $secret, string $afterRemark = '', array $params = []): string
    {
        throw new \Exception('Not implemented');
    }
}
