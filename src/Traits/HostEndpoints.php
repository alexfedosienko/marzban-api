<?php

namespace AlexFedosienko\Traits;

use AlexFedosienko\Models\Host;

trait HostEndpoints
{
    /**
     * Получение списка хостов из Marzban
     *
     * @return Array of Host
     */
    public function getHosts(): array
    {
        $response = $this->getRequest()->get('/api/hosts');
        return Host::makeArrayOfHosts($response->getBody());
    }
}
