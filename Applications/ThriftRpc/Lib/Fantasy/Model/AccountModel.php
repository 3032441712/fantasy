<?php

namespace Fantasy\Model;

use Fantasy\Service\AccountService;
class AccountModel
{
    const ACCOUNT_TITILE_EXISTS = 1504;

    const ACCOUNT_ACCOUNTID_NOT_FOUND = 1506;

    public static function fantasyAccountAdd($data = [])
    {
        $account_data = AccountService::findAccountInfoByTitle($data['user_id'], $data['account_title']);
        if (isset($account_data['account_id'])) {
            throw new \Exception('账号标题已经存在,请重新输入.', self::ACCOUNT_TITILE_EXISTS);
        }

        return AccountService::saveAccountData($data);
    }

    /**
     * 更新账号信息
     * 
     * @param array $data       数据数组
     * @param int   $account_id 账号ID
     * 
     * @return int 影响的行数
     */
    public static function fantasyAccountUpdate($data, $account_id)
    {
        $account_data = AccountService::findAccountInfoById($account_id);
        if (isset($account_data['account_id']) == false) {
            throw new \Exception('没有找到需需要更新的数据.', self::ACCOUNT_ACCOUNTID_NOT_FOUND);
        }

        if (isset($data['account_title'])) {
            $account = AccountService::findAccountInfoByTitle($account_data['user_id'], $data['account_title'], $account_id);
            if (isset($account['account_id'])) {
                throw new \Exception('账号标题已经存在,请重新输入.', self::ACCOUNT_TITILE_EXISTS);
            }
        }
        $data['account_updated'] = isset($data['account_updated']) ? $data['account_updated'] : date('Y-m-d H:i:s');

        return AccountService::saveAccountData($data, $account_id);
    }

    public static function fantasyAccountInfo($account_id)
    {
        $account_data = AccountService::findAccountInfoById($account_id);
        if (isset($account_data['account_id']) == false) {
            throw new \Exception('没有找到需需要更新的数据.', self::ACCOUNT_ACCOUNTID_NOT_FOUND);
        }

        return $account_data;
    }

    public static function fantasyAccountList($user_id, $page, $pagesize)
    {
        return AccountService::findAccountAllData(['user_id' => $user_id], $page, $pagesize);
    }
}