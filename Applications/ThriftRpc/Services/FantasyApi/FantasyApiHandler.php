<?php

namespace Services\FantasyApi;

use Fantasy\Model\UserModel;

class FantasyApiHandler implements FantasyApiIf
{
    public function fantasyUserLogin($input_data)
    {
        return $input_data.'123'.UserModel::fantasyUserLogin('1', '2');
    }

    public function fantasyUserLogout($input_data)
    {
        
    }

    public function fantasyUserInfo($input_data)
    {
        
    }

    public function fantasyUserList($input_data)
    {
        
    }
}
