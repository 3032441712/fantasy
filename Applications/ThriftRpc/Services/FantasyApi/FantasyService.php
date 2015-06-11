<?php

namespace Services\FantasyApi;

abstract class FantasyService
{
    /**
     * 将获取的参数转换成数组
     * 
     * @param string $input_params 接收到的参数
     * 
     * @return array
     */
    public function loadParams($input_params)
    {
        return json_decode($input_params, true);
    }
}
