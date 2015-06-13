<?php

namespace Services\AccountService;

use Fantasy\Base\ThriftService;
class AccountServiceHandler extends ThriftService implements AccountServiceIf
{
    public function fantasyAccountAdd($input_data)
    {
        try {
            $app_params = $this->loadParams($input_data);
        } catch (\PDOException $e) {
            throw new Apiception(['code' => $e->getCode(), 'message' => '数据库级别错误,请通知接口负责人.']);
        } catch (\Exception $e) {
            throw new Apiception(['code' => $e->getCode(), 'message' => $e->getMessage()]);
        }

        return $this->response(0, 'success', 'abcedddd');
    }

    public function fantasyAccountUpdate($input_data)
    {
        try {
            $app_params = $this->loadParams($input_data);
        } catch (\PDOException $e) {
            throw new Apiception(['code' => $e->getCode(), 'message' => '数据库级别错误,请通知接口负责人.']);
        } catch (\Exception $e) {
            throw new Apiception(['code' => $e->getCode(), 'message' => $e->getMessage()]);
        }

        return $this->response(0, 'success', '账户更新成功');
    }

    public function fantasyAccountInfo($input_data)
    {
        try {
            $app_params = $this->loadParams($input_data);
        } catch (\PDOException $e) {
            throw new Apiception(['code' => $e->getCode(), 'message' => '数据库级别错误,请通知接口负责人.']);
        } catch (\Exception $e) {
            throw new Apiception(['code' => $e->getCode(), 'message' => $e->getMessage()]);
        }

        return $this->response(0, 'success', '查询账号详细信息');
    }

    public function fantasyAccountList($input_data)
    {
        try {
            $app_params = $this->loadParams($input_data);
        } catch (\PDOException $e) {
            throw new Apiception(['code' => $e->getCode(), 'message' => '数据库级别错误,请通知接口负责人.']);
        } catch (\Exception $e) {
            throw new Apiception(['code' => $e->getCode(), 'message' => $e->getMessage()]);
        }

        return $this->response(0, 'success', '账号列表');
    }
}
