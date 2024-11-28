<?php

namespace AlexFedosienko\MarzbanAPI\Models;

class User
{
    /**
     * Имя пользователя в Marzban
     *
     * @param string $username
     */

    public string $username;
    public ?int $data_limit;
    public string $data_limit_reset_strategy;
    public ?string $note;
    public ?int $expire;
    public string $status; // => active
    public int $used_traffic;
    public int $lifetime_used_traffic;
    public ?string $online_at; // => 2024-11-06T10:27:38
    public string $created_at; // => 2024-05-17T10:24:56

    public static function make(array $userJson): User
    {
        $user = new User();
        $user->username = $userJson['username'];
        $user->data_limit = $userJson['data_limit'];
        $user->data_limit_reset_strategy = $userJson['data_limit_reset_strategy'];
        $user->note = $userJson['note'];
        $user->expire = $userJson['expire'];
        $user->status = $userJson['status'];
        $user->used_traffic = $userJson['used_traffic'];
        $user->lifetime_used_traffic = $userJson['lifetime_used_traffic'];
        $user->online_at = $userJson['online_at'];
        $user->created_at = $userJson['created_at'];
        return $user;
    }

    public static function makeArrayOfUsers(array $response): array
    {
        $users = [];
        foreach ($response['users'] as $user) {
            $users[] = User::make($user);
        }

        return $users;
        // [proxies] => Array
        // (
        //     [vless] => Array
        //         (
        //             [id] => 809e05e2-8bdc-4a32-9a19-548b087a149f
        //             [flow] =>
        //         )

        // )

        //     [expire] => 1733338799
        //     [data_limit] =>
        //     [data_limit_reset_strategy] => no_reset
        //     [note] =>
        //     [sub_updated_at] =>
        //     [sub_last_user_agent] =>
        //     [online_at] => 2024-11-06T10:27:38
        //     [on_hold_expire_duration] =>
        //     [on_hold_timeout] =>
        //     [auto_delete_in_days] =>
        //     [username] => Arina
        //     [status] => active
        //     [used_traffic] => 168327121466
        //     [lifetime_used_traffic] => 168327121466
        //     [created_at] => 2024-05-17T10:24:56
        //     [links] => Array
        //         (
        //             [0] => vless://809e05e2-8bdc-4a32-9a19-548b087a149f@s1.vpn360.ru:8443?security=reality&type=tcp&headerType=&path=&host=&sni=cdn.discordapp.com&fp=chrome&pbk=SbVKOEMjK0sIlbwg4akyBg5mL5KZwwB-ed4eEE7YnRc&sid=#%F0%9F%87%AB%F0%9F%87%B7%20%D0%A4%D1%80%D0%B0%D0%BD%D1%86%D0%B8%D1%8F
        //             [1] => False
        //         )

        //     [subscription_url] => /sub/QXJpbmEsMTczMDg5MzM0NwcujMfnb5pQ
        //     [excluded_inbounds] => Array
        //         (
        //             [vless] => Array
        //                 (
        //                     [0] => VLESS GRPC REALITY
        //                 )

        //         )
        // )
    }
}
