<?php

namespace AlexFedosienko\MarzbanAPI\Traits;

use AlexFedosienko\MarzbanAPI\Models\Host;

trait HostEndpoints
{
    /**
     * getHosts
     *
     * @return Host[]
     */
    public function getHosts(): array
    {
        $response = $this->getRequest()->get('/api/hosts');
        return Host::makeArrayOfHosts($response->getBody());
    }
}
