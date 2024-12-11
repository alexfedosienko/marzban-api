<?php

namespace AlexFedosienko\MarzbanAPI\Models;

use AlexFedosienko\MarzbanAPI\Models\Hosts\VMessTCP;
use AlexFedosienko\MarzbanAPI\Models\Hosts\ShadowsocksTCP;
use AlexFedosienko\MarzbanAPI\Models\Hosts\VMessWebsocket;
use AlexFedosienko\MarzbanAPI\Models\Hosts\VLessTCPReality;
use AlexFedosienko\MarzbanAPI\Models\Hosts\VLessGRPCReality;
use AlexFedosienko\MarzbanAPI\Models\Hosts\TrojanWebsocketTLS;


abstract class Host
{
    /**
     * make
     *
     * @param  array $hostJson
     * @return Host
     */
    abstract public static function make(array $hostJson): Host;

    /**
     * toUrl
     *
     * @param  string $secret
     * @param  string $afterRemark
     * @param  array $params
     *
     * @return string
     */
    abstract public function toUrl(string $secret, string $afterRemark = '', array $params = []): string;

    /**
     * makeArrayOfHosts
     *
     * @param  array $response
     * @return Host[]
     */

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
