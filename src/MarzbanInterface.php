<?php

namespace AlexFedosienko\MarzbanAPI;

use AlexFedosienko\MarzbanAPI\Models\User;

interface MarzbanInterface
{
    /**
     * Get host list from marzban
     *
     * @return Host[]
     */
    public function getHosts(): array;

    /**
     * Get node list from marzban
     *
     * @return Node[]
     */
    public function getNodes(): array;

    /**
     * Create user in marzban
     *
     * @param  string $username
     * @param  string $secret
     * @param  int $dataLimit
     * @param  int $expire
     * @return User
     */
    public function createUser(string $username, string $secret = '', $dataLimit = 0, $expire = 0): User;

    /**
     * Get user list from marzban
     *
     * @return User[]
     */
    public function getUsers(): array;

    /**
     * Get user from marzban
     *
     * @param  string $username
     * @return User
     */
    public function getUser(string $username): User;

    /**
     * Update user in marzban
     *
     * @param  string $username
     * @param  int $dataLimit
     * @param  int $expire
     * @return User
     */
    public function updateUser(string $username, $dataLimit = 0, $expire = 0): User;

    /**
     * Delete user from Marzban
     *
     * @param  string $username
     * @return Bool
     */
    public function deleteUser(string $username): Bool;
}
