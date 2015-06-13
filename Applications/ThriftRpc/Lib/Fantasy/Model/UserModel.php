<?php

namespace Fantasy\Model;

use Fantasy\Service\UserService;
class UserModel
{
    const USER_DATA_NOT_EXITS = 1003;

    const USER_DATA_PASSWORD_NOT_RIGHT = 1004;

    /**
     * 用户登陆系统
     * 
     * @param string $username 用户名
     * @param string $password 用户密码
     * 
     * @return array
     * @throws \Exception
     */
    public static function fantasyUserLogin($username, $password)
    {
        $userdata = UserService::findUserByUsername($username);
        if (isset($userdata['user_id']) == false) {
            throw new \Exception('该用户不存在,请确定输入的用户名是否正确.', UserModel::USER_DATA_NOT_EXITS);
        }

        if (md5($password) != $userdata['password']) {
            throw new \Exception('输入的密码有误,请检查密码是否输入正确.', UserModel::USER_DATA_PASSWORD_NOT_RIGHT);
        }

        unset($userdata['password']);

        return $userdata;
    }

    /**
     * 根据用户ID获取用户信息
     * 
     * @param int $user_id 用户ID
     * 
     * @return array
     * @throws \Exception
     */
    public static function fantasyUserInfo($user_id)
    {
        $userdata = UserService::findUserByUserId($user_id);
        if (isset($userdata['user_id']) == false) {
            throw new \Exception('根据该用户ID未找到用户数据.', UserModel::USER_DATA_NOT_EXITS);
        }

        unset($userdata['password']);

        return $userdata;
    }
}
