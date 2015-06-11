<?php

namespace Fantasy\Service;

use Database\Base\Db;

class UserService
{
    /**
     * 根据用户名查询用户信息
     * 
     * @param string $username 用户名称
     * 
     * @return array|bool
     */
    public static function findUserByUsername($username)
    {
        $data = Db::findOne('SELECT user_id, username, password, email, qq, mobile, user_updated, user_created FROM fantasy_users WHERE username = :username LIMIT 1', [':username' => $username]);

        return $data;
    }

    /**
     * 根据用户ID查询用户的信息
     * 
     * @param int $user_id 用户ID
     * 
     * @return array|bool
     */
    public static function findUserByUserId($user_id)
    {
        $data = Db::findOne('SELECT user_id, username, password, email, qq, mobile, user_updated, user_created FROM fantasy_users WHERE user_id = :user_id LIMIT 1', [':user_id' => $user_id]);

        return $data;
    }
}
