<?php

namespace Services\UserService;

use Fantasy\Model\UserModel;
use Fantasy\Base\ThriftService;

class UserServiceHandler extends ThriftService implements UserServiceIf
{
    public function fantasyUserLogin($input_data)
    {
        $app_params = $this->loadParams($input_data);
        $username = isset($app_params['username']) ? $app_params['username'] : '';
        $password = isset($app_params['password']) ? $app_params['password'] : '';

        if ($username == '') {
            throw new Apiception(['code' => ThriftService::USER_PARAM_USERNAME_NOT_FOUND, 'message' => '请输入用户名']);
        }

        if ($password == '') {
            throw new Apiception(['code' => ThriftService::USER_APRAM_PASSWORD_NOT_FOUND, 'message' => '请输入密码']);
        }

        try {
            $data = UserModel::fantasyUserLogin($username, $password);

            return $this->response(0, 'success', $data);
        } catch (\PDOException $e) {
            throw new Apiception(['code' => '900', 'message' => '系统内部数据库异常,请联系服务管理人员.']);
        } catch (\Exception $e) {
            throw new Apiception(['code' => $e->getCode(), 'message' => $e->getMessage()]);
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
            throw new Apiception(['code' => ThriftService::USER_PARAM_USERID_NOT_FOUND, 'message' => '请输入正确的用户ID']);
        }

        try {
            $data = UserModel::fantasyUserInfo($user_id);

            return $this->response(0, 'success', $data);
        } catch (\PDOException $e) {
            throw new Apiception(['code' => '900', 'message' => '系统内部数据库异常,请联系服务管理人员.']);
        } catch (\Exception $e) {
            throw new Apiception(['code' => $e->getCode(), 'message' => $e->getMessage()]);
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
