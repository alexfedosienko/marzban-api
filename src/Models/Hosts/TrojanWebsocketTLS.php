<?php

namespace AlexFedosienko\Models\Hosts;

use AlexFedosienko\Models\Host;

class TrojanWebsocketTLS extends Host
{
    public static function make(array $hostJson): Host
    {
        throw new \Exception('Not implemented');
    }
}