<?php

namespace Services\FantasyApi;

abstract class FantasyService
{
    const PARAM_APPID_NOT_FOUND = 1000;

    const USER_PARAM_USERNAME_NOT_FOUND = 1001;

    const USER_APRAM_PASSWORD_NOT_FOUND = 1002;

    const USER_PARAM_USERID_NOT_FOUND = 1401;

    /**
     * 将获取的参数转换成数组
     * 
     * @param string $input_params 接收到的参数
     * 
     * @return array
     */
    public function loadParams($input_params)
    {
        $params = json_decode($input_params, true);

        // 检查APP_ID是否存在
        if (isset($params['app_id']) == false) {
            throw new Apiception(['code' => FantasyService::PARAM_APPID_NOT_FOUND, 'message' => '请提供一个应用ID来访问该接口.']);
        }

        return $params;
    }

    /**
     * 接口返回的响应数据
     * 
     * @param int    $code    状态码.
     * @param string $message 消息
     * @param mixed  $data    返回的数据
     * 
     * @return string
     */
    public function response($code, $message, $data = '')
    {
        if ($code == 0) {
            return '{"response":{"code":"'.$code.'","message":"'.$message.'","data":'.json_encode($data, JSON_UNESCAPED_UNICODE).'}}';
        } else {
            return '{"response":{"code":"'.$code.'","message":"'.$message.'"}';
        }
    }
}
