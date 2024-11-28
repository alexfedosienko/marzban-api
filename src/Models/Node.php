<?php

namespace AlexFedosienko\MarzbanAPI\Models;

class Node
{
    public string $name;
    public string $address;
    public int $port;
    public int $api_port;
    public int $id;
    public string $xray_version;
    public string $status;
    public ?string $message;

    /**
     * make
     *
     * @param  array $nodeJson
     * @return Node
     */
    public static function make(array $nodeJson): Node
    {
        $node = new Node();
        $node->name = $nodeJson['name'];
        $node->address = $nodeJson['address'];
        $node->port = $nodeJson['port'];
        $node->api_port = $nodeJson['api_port'];
        $node->id = $nodeJson['id'];
        $node->xray_version = $nodeJson['xray_version'];
        $node->status = $nodeJson['status'];
        $node->message = $nodeJson['message'];
        return $node;
    }

    /**
     * makeArrayOfNodes
     *
     * @param  array $response
     * @return Node[]
     */
    public static function makeArrayOfNodes(array $response): array
    {
        $nodes = [];
        foreach ($response as $node) {
            $nodes[] = Node::make($node);
        }
        return $nodes;
    }
}
