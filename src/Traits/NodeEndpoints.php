<?php

namespace AlexFedosienko\MarzbanAPI\Traits;

use AlexFedosienko\MarzbanAPI\Models\Node;

trait NodeEndpoints
{
    /**
     * getNodes
     *
     * @return Node[]
     */
    public function getNodes(): array
    {
        $response = $this->getRequest()->get('/api/nodes');
        return Node::makeArrayOfNodes($response->getBody());
    }
}
