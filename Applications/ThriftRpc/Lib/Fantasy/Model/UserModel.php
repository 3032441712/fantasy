<?php

namespace Fantasy\Model;

use Fantasy\Service\UserService;
class UserModel
{
    public static function fantasyUserLogin()
    {
        return UserService::fantasyUserLogin();
    }
}
