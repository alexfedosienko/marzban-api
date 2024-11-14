<?php

namespace AlexFedosienko\Models;

use AlexFedosienko\Models\Hosts\VMessTCP;
use AlexFedosienko\Models\Hosts\ShadowsocksTCP;
use AlexFedosienko\Models\Hosts\VMessWebsocket;
use AlexFedosienko\Models\Hosts\VLessTCPReality;
use AlexFedosienko\Models\Hosts\VLessGRPCReality;
use AlexFedosienko\Models\Hosts\TrojanWebsocketTLS;

abstract class Host
{
    abstract public static function make(array $hostJson): Host;

    public static function makeArrayOfHosts(array $response): array
    {
        $hosts = [];
        foreach ($response as $type => $h) {
            foreach ($h as $host) {
                switch ($type) {
                    case 'VMess TCP':
                        // $hosts['vmess-tcp'][] = VMessTCP::make($host);
                        $hosts[] = VMessTCP::make($host);
                        break;
                    case 'VMess Websocket':
                        // $hosts['vmess-websocket'][] = VMessWebsocket::make($host);
                        $hosts[] = VMessWebsocket::make($host);
                        break;
                    case 'VLESS TCP REALITY':
                        // $hosts['vless-tcp-reality'][] = VLessTCPReality::make($host);
                        $hosts[] = VLessTCPReality::make($host);
                        break;
                    case 'VLESS GRPC REALITY':
                        // $hosts['vless-grpc-reality'][] = VLessGRPCReality::make($host);
                        $hosts[] = VLessGRPCReality::make($host);
                        break;
                    case 'Trojan Websocket TLS':
                        // $hosts['trojan-websocket-tls'][] = TrojanWebsocketTLS::make($host);
                        $hosts[] = TrojanWebsocketTLS::make($host);
                        break;
                    case 'Shadowsocks TCP':
                        // $hosts['shadowsocks-tcp'][] = ShadowsocksTCP::make($host);
                        $hosts[] = ShadowsocksTCP::make($host);
                        break;
                }
            }
        }
        return $hosts;
    }
}
