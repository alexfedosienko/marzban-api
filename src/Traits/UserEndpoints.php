<?php

namespace AlexFedosienko\MarzbanAPI\Traits;

use AlexFedosienko\MarzbanAPI\Utils\Uuid;
use AlexFedosienko\MarzbanAPI\Models\User;

trait UserEndpoints
{
    /**
     * createUser
     *
     * @param  string $username
     * @param  string $secret
     * @param  int $dataLimit
     * @param  int $expire
     * @return User
     */
    public function createUser(string $username, string $secret = '', $dataLimit = 0, $expire = 0): User
    {
        if (empty($secret)) {
            $secret = Uuid::v4();
        }

        $payload = [
            'username' => $username,
            'proxies' => [
                'vless' => [
                    'id' => $secret,
                ]
            ],
            'inbounds' => [
                'vless' => [
                    'VLESS TCP REALITY',
                ]
            ],
        ];
        if ($dataLimit > 0) $payload['data_limit'] = $dataLimit;
        if ($expire > 0) $payload['expire'] = $expire;
        $response = $this->getRequest()->post('/api/user', [], $payload, true);
        $this->checkExceptions($response);

        return User::make($response->getBody());
    }


    /**
     * getUsers
     *
     * @return User[]
     */
    public function getUsers(): array
    {
        $response = $this->getRequest()->get('/api/users');
        return User::makeArrayOfUsers($response->getBody());
    }

    /**
     * getUser
     *
     * @param  string $username
     * @return User
     */
    public function getUser(string $username): User
    {
        $response = $this->getRequest()->get('/api/user/' . $username);
        $this->checkExceptions($response);
        return User::make($response->getBody());
    }

    /**
     * updateUser
     *
     * @param  string $username
     * @param  int $dataLimit
     * @param  int $expire
     * @return User
     */
    public function updateUser(string $username, $dataLimit = 0, $expire = 0): User
    {
        $payload = [];
        if ($dataLimit > 0) $payload['data_limit'] = $dataLimit;
        if ($expire > 0) $payload['expire'] = $expire;

        $response = $this->getRequest()->put('/api/user/' . $username, [], $payload, true);
        $this->checkExceptions($response);
        return User::make($response->getBody());
    }

    /**
     * deleteUser
     *
     * @param  string $username
     * @return Bool
     */
    public function deleteUser(string $username): Bool
    {
        $response = $this->getRequest()->delete('/api/user/' . $username);
        $this->checkExceptions($response);
        return true;
    }
}
