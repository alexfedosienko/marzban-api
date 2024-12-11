<?php

namespace AlexFedosienko\MarzbanAPI\Models\Hosts;

use AlexFedosienko\MarzbanAPI\Models\Host;

class VMessTCP extends Host
{
    public string $remark;
    public string $address;
    public ?string $port;
    public ?string $sni;
    public ?string $host;
    public ?string $path;
    public ?string $security;
    public ?string $alpn;
    public ?string $fingerprint;
    public ?string $allowinsecure;
    public ?string $is_disabled;
    public ?string $mux_enable;
    public ?string $fragment_setting;
    public ?string $random_user_agent;

    /**
     * make
     *
     * @param  array $hostJson
     * @return Host
     */
    public static function make(array $hostJson): Host
    {
        $host = new VMessTCP();
        $host->remark = $hostJson['remark'];
        $host->address = $hostJson['address'];
        $host->port = $hostJson['port'];
        $host->sni = $hostJson['sni'];
        $host->host = $hostJson['host'];
        $host->path = $hostJson['path'];
        $host->security = $hostJson['security'];
        $host->alpn = $hostJson['alpn'];
        $host->fingerprint = $hostJson['fingerprint'];
        $host->allowinsecure = $hostJson['allowinsecure'];
        $host->is_disabled = $hostJson['is_disabled'];
        $host->mux_enable = $hostJson['mux_enable'];
        $host->fragment_setting = $hostJson['fragment_setting'];
        $host->random_user_agent = $hostJson['random_user_agent'];

        return $host;
    }

    /**
     * toUrl
     *
     * @param  string $secret
     * @param  string $afterRemark
     * @param  array $params
     *
     * @return string
     */
    public function toUrl(string $secret, string $afterRemark = '', array $params = []): string
    {
        $data = array_merge([
            'add' => $this->address,
            'aid' => '0',
            'host' => $this->host,
            'id' => $secret,
            'net' => 'tcp',
            'path' => $this->path,
            'port' => $this->port,
            'ps' => 'vmess',
            'scy' => 'auto',
            'tls' => 'none',
            'type' => 'http',
            'v' => '2'
        ], $params);

        return 'vmess://' . base64_encode(json_encode($data));
    }
}
