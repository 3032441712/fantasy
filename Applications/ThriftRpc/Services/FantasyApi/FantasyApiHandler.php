<?php

namespace Services\FantasyApi;

use Fantasy\Model\UserModel;

class FantasyApiHandler extends FantasyService implements FantasyApiIf
{
    public function fantasyUserLogin($input_data)
    {
        $app_params = $this->loadParams($input_data);
        $username = isset($app_params['username']) ? $app_params['username'] : '';
        $password = isset($app_params['password']) ? $app_params['password'] : '';

        if ($username == '') {
            throw new Apiception(['code' => FantasyService::USER_PARAM_USERNAME_NOT_FOUND, 'message' => '请输入用户名']);
        }

        if ($password == '') {
            throw new Apiception(['code' => FantasyService::USER_APRAM_PASSWORD_NOT_FOUND, 'message' => '请输入密码']);
        }

        try {
            $data = UserModel::fantasyUserLogin($username, $password);

            return $this->response(0, 'success', $data);
        } catch (\PDOException $e) {
            return $this->response(900, '系统内部错误:'.$e->getMessage());
        } catch (\Exception $e) {
            return $this->response($e->getCode(), $e->getMessage());
        }
    }

    public function fantasyUserLogout($input_data)
    {
        
    }

    public function fantasyUserInfo($input_data)
    {
        $app_params = $this->loadParams($input_data);
        $user_id = isset($app_params['user_id']) ? $app_params['user_id'] : 0;

        if ($user_id == 0) {
            throw new Apiception(['code' => FantasyService::USER_PARAM_USERID_NOT_FOUND, 'message' => '请输入正确的用户ID']);
        }

        try {
            $data = UserModel::fantasyUserInfo($user_id);

            return $this->response(0, 'success', $data);
        } catch (\PDOException $e) {
            return $this->response(900, '系统内部错误:'.$e->getMessage());
        } catch (\Exception $e) {
            return $this->response($e->getCode(), $e->getMessage());
        }
    }

    public function fantasyUserList($input_data)
    {
        
    }

    public function fantasyUserAdd($input_data)
    {
        
    }

    public function fantasyUserUpdate($input_data)
    {
        
    }
}
