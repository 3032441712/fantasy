<?php

namespace Services\FantasyApi;

use Fantasy\Model\UserModel;

class FantasyApiHandler extends FantasyService implements FantasyApiIf
{
    public function fantasyUserLogin($input_data)
    {
        $app_params = $this->loadParams($input_data);
        if (isset($app_params['app_id']) == false) {
            throw new Apiception(['code' => 1000, 'msg' => '请提供一个应用ID来访问该接口.']);
        }

        return $app_params['app_id'].'123'.UserModel::fantasyUserLogin('1', '2');
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
