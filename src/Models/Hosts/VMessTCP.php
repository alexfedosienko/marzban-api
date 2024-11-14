<?php

namespace AlexFedosienko\Models\Hosts;

use AlexFedosienko\Models\Host;

class VMessTCP extends Host
{
    public static function make(array $hostJson): Host
    {
        throw new \Exception('Not implemented');
    }
}
