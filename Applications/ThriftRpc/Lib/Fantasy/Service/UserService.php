<?php

namespace Fantasy\Service;

use Database\Base\Db;
class UserService
{
    public static function fantasyUserLogin()
    {
        $data = Db::findOne('SELECT 1+1 as number');
        return 'fantasyUserLoginService'.$data['number'];
    }
}
