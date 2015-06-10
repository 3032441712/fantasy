<?php

namespace Fantasy\Service;

use Database\Base\Db;
class UserService
{
    public static function fantasyUserLogin($username, $password)
    {
        $data = Db::findOne('SELECT 1+1 as number');
        return 'fantasyUserLogin'.$data['number'];
    }
}
