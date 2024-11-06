<?php

namespace AlexFedosienko\Traits;

use AlexFedosienko\Utils\Uuid;
use AlexFedosienko\Models\User;

trait UserEndpoints
{

    /**
     * Создание нового пользователя в Marzban
     *
     * @return User
     */
    public function createUser(string $username, string $secret = ''): User
    {
        // if (empty($secret)) {
        //     $secret = Uuid::v4();
        // }
        // echo $username;

        $user = new User();
        // $user->username;
        return $user;
    }

    public function getUsers(): array
    {
        $response = $this->getRequest()->get('/api/users');
        return User::makeArrayOfUsers($response->getBody());
    }

    public function getUser(string $username): User
    {
        $response = $this->getRequest()->get('/api/user/' . $username);
        return User::make($response->getBody());
    }

    public function updateUser(): User
    {
        return new User();
    }

    public function deleteUser(): Bool
    {
        return true;
    }
}
