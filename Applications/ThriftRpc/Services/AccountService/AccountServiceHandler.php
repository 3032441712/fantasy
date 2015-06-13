<?php

namespace Services\AccountService;

use Fantasy\Base\ThriftService;
use Fantasy\Model\AccountModel;
class AccountServiceHandler extends ThriftService implements AccountServiceIf
{
    const ACCOUNT_PARAM_USERID_NOT_FOUND = 1501;

    const ACCOUNT_PARAM_ACCOUNT_TITLE_NOT_FOUND = 1502;

    const ACCOUNT_PARAM_ACCOUNT_CONTENT_NOT_FOUND = 1503;

    public function fantasyAccountAdd($input_data)
    {
        $datetime = date('Y-m-d H:i:s');
        try {
            $app_params = $this->loadParams($input_data);
            $data = [
                'user_id' => isset($app_params['user_id']) ? intval($app_params['user_id']) : '',
                'account_title' => isset($app_params['account_title']) ? $app_params['account_title'] : '',
                'account_content' => isset($app_params['account_content']) ? $app_params['account_content'] : '',
                'account_updated' => $datetime,
                'account_created' => isset($app_params['account_created']) ? $app_params['account_created'] : $datetime
            ];

            if ($data['user_id'] == '') {
                throw new Apiception(['code' => self::ACCOUNT_PARAM_USERID_NOT_FOUND, 'message' => '请输入user_id字段.']);
            }

            if ($data['account_title'] == '') {
                throw new Apiception(['code' => self::ACCOUNT_PARAM_ACCOUNT_TITLE_NOT_FOUND, 'message' => '请输入account_title字段.']);
            }

            if ($data['account_content'] == '') {
                throw new Apiception(['code' => self::ACCOUNT_PARAM_ACCOUNT_CONTENT_NOT_FOUND, 'message' => '请输入account_content字段.']);
            }

            $account_id = AccountModel::fantasyAccountAdd($data);

            return $this->response(0, 'success', '{"account_id":"'.$account_id.'"}');
        } catch (\PDOException $e) {
            throw new Apiception(['code' => $e->getCode(), 'message' => $e->getMessage()]);
//             throw new Apiception(['code' => $e->getCode(), 'message' => '数据库级别错误,请通知接口负责人.']);
        } catch (\Exception $e) {
            throw new Apiception(['code' => $e->getCode(), 'message' => $e->getMessage()]);
        }
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
