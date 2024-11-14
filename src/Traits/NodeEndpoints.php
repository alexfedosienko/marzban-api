<?php

namespace AlexFedosienko\Traits;

use AlexFedosienko\Models\Node;

trait NodeEndpoints
{
    /**
     * Получение списка нод из Marzban
     *
     * @return Array of Node
     */
    public function getNodes(): array
    {
        $response = $this->getRequest()->get('/api/nodes');
        return Node::makeArrayOfNodes($response->getBody());
    }
}
