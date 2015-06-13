<?php

namespace Fantasy\Model;

use Fantasy\Service\AccountService;
class AccountModel
{
    const ACCOUNT_TITILE_EXISTS = 1504;

    public static function fantasyAccountAdd($data = [])
    {
        $account_data = AccountService::findAccountInfoByTitle($data['user_id'], $data['account_title']);
        if (isset($account_data['account_id'])) {
            throw new \Exception('账号标题已经存在,请重新输入.', self::ACCOUNT_TITILE_EXISTS);
        }

        return AccountService::saveAccountData($data);
    }

    public static function fantasyAccountUpdate()
    {
        
    }

    public static function fantasyAccountInfo()
    {
        
    }

    public static function fantasyAccountList()
    {
        
    }
}