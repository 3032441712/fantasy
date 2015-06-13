<?php

namespace Services\AccountService;

use Fantasy\Base\ThriftService;
class AccountServiceHandler extends ThriftService implements AccountServiceIf
{
    public function fantasyAccountAdd($input_data)
    {
        $app_params = $this->loadParams($input_data);

        return $this->response(0, 'success', 'abcedddd');
    }

    public function fantasyAccountUpdate($input_data)
    {
        $app_params = $this->loadParams($input_data);

        return $this->response(0, 'success', '账户更新成功');
    }

    public function fantasyAccountInfo($input_data)
    {
        $app_params = $this->loadParams($input_data);

        return $this->response(0, 'success', '查询账号详细信息');
    }

    public function fantasyAccountList($input_data)
    {
        $app_params = $this->loadParams($input_data);

        return $this->response(0, 'success', '账号列表');
    }
}
