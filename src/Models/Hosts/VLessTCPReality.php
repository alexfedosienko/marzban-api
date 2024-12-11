<?php

namespace AlexFedosienko\MarzbanAPI\Models\Hosts;

use AlexFedosienko\MarzbanAPI\Models\Host;
use AlexFedosienko\MarzbanAPI\Exceptions\EmptyParameterException;

class VLessTCPReality extends Host
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
        $host = new VLessTCPReality();
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
        $params = array_merge([
            'security' => 'reality',
            'type' => 'tcp',
            'headerType' => '',
            'path' => $this->path,
            'host' => $this->host,
            'sni' => $this->sni,
            'fp' => $this->fingerprint,
            'pbk' => '',
            'sid' => '',
        ], $params);

        if (empty($params['pbk'])) {
            throw new EmptyParameterException('Не указан pbk');
        }

        if (empty($params['port']) && empty($this->port)) {
            throw new EmptyParameterException('Не указан port');
        }

        return 'vless://' . $secret . '@' . $this->address . ':' . ($this->port ? $this->port : $params['port']) . '?' . http_build_query($params) . '#' . rawurlencode($this->remark . $afterRemark);
    }
}
