<?php

namespace Services\AccountService;

use Fantasy\Base\ThriftService;
use Fantasy\Model\AccountModel;
use Fantasy\Base\Application;
class AccountServiceHandler extends ThriftService implements AccountServiceIf
{
    const ACCOUNT_PARAM_USERID_NOT_FOUND = 1501;

    const ACCOUNT_PARAM_ACCOUNT_TITLE_NOT_FOUND = 1502;

    const ACCOUNT_PARAM_ACCOUNT_CONTENT_NOT_FOUND = 1503;

    const ACCOUNT_PARAM_ACCOUNT_ID_NOT_FOUND = 1505;

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

            return $this->response(0, 'success', ['account_id' => $account_id]);
        } catch (\PDOException $e) {
            throw new Apiception(['code' => $e->getCode(), 'message' => '数据库级别错误,请通知接口负责人.']);
        } catch (\Exception $e) {
            throw new Apiception(['code' => $e->getCode(), 'message' => $e->getMessage()]);
        }
    }

    public function fantasyAccountUpdate($input_data)
    {
        try {
            $app_params = $this->loadParams($input_data);
            $account_id = isset($app_params['account_id']) ? intval($app_params['account_id']) : 0;
            if ($account_id == 0) {
                throw new Apiception(['code' => self::ACCOUNT_PARAM_USERID_NOT_FOUND, 'message' => '请输入正确的account_id']);
            }

            unset(
                $app_params['account_id']
            );
            $row_count = AccountModel::fantasyAccountUpdate($app_params, $account_id);

            return $this->response(0, 'success', ['account_id' => $account_id, 'row_count' => $row_count]);
        } catch (\PDOException $e) {
            throw new Apiception(['code' => $e->getCode(), 'message' => '数据库级别错误,请通知接口负责人.']);
        } catch (\Exception $e) {
            throw new Apiception(['code' => $e->getCode(), 'message' => $e->getMessage()]);
        }
    }

    public function fantasyAccountInfo($input_data)
    {
        try {
            $app_params = $this->loadParams($input_data);
            $account_id = isset($app_params['account_id']) ? $app_params['account_id'] : 0;
            if ($account_id == 0) {
                throw new Apiception(['code' => self::ACCOUNT_PARAM_USERID_NOT_FOUND, 'message' => '请输入正确的account_id']);
            }
            $account_info = AccountModel::fantasyAccountInfo($account_id);

            return $this->response(0, 'success', $account_info);
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
            $user_id = isset($app_params['user_id']) ? intval($app_params['user_id']) : '';
            $page = isset($app_params['page']) ? intval($app_params['page']) : 1;
            $pagesize = isset($app_params['pagesize']) ? intval($app_params['pagesize']) : 20;
            $accounts = AccountModel::fantasyAccountList($user_id, $page, $pagesize);

            if ($user_id == '') {
                throw new Apiception(['code' => self::ACCOUNT_PARAM_USERID_NOT_FOUND, 'message' => '请输入user_id字段.']);
            }

            return $this->response(0, 'success', $accounts);
        } catch (\PDOException $e) {
            throw new Apiception(['code' => $e->getCode(), 'message' => '数据库级别错误,请通知接口负责人.']);
        } catch (\Exception $e) {
            throw new Apiception(['code' => $e->getCode(), 'message' => $e->getMessage()]);
        }

        return $this->response(0, 'success', '账号列表');
    }
}
