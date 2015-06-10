<?php

namespace Fantasy\Model;

use Fantasy\Service\UserService;
class UserModel
{
    /**
     * 用户登陆系统
     * 
     * @param string $username 用户名
     * @param string $password 用户密码
     * 
     * @return string
     */
    public static function fantasyUserLogin($username, $password)
    {
        return UserService::fantasyUserLogin($username, $password);
    }
}
