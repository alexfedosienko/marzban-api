<?php

namespace AlexFedosienko\MarzbanAPI\Models\Hosts;

use AlexFedosienko\MarzbanAPI\Models\Host;

class VMessTCP extends Host
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
}
