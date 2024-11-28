<?php

namespace AlexFedosienko\MarzbanAPI\Models\Hosts;

use AlexFedosienko\MarzbanAPI\Models\Host;

class VMessWebsocket extends Host
{
    public static function make(array $hostJson): Host
    {
        throw new \Exception('Not implemented');
    }
}
