<?php

namespace Fantasy\Service;

use Database\Base\Db;
class AccountService
{
    public static $account_field = [
        'account_id',
        'user_id',
        'account_title',
        'account_content',
        'account_updated',
        'account_created'
    ];

    /**
     * 根据账号ID查询账号信息
     * 
     * @param int $account_id 账号ID
     * 
     * @return array
     */
    public static function findAccountInfoById($account_id)
    {
        $sql = 'SELECT '.implode(',', self::$account_field).' FROM fantasy_account WHERE account_id = :account_id LIMIT 1';
        $account_data = Db::findOne($sql, [':account_id' => $account_id]);

        return $account_data;
    }

    /**
     * 根据账号标题取得账号信息
     * 
     * @param int    $user_id       用户ID
     * @param string $account_title 账号标题
     * 
     * @return array
     */
    public static function findAccountInfoByTitle($user_id, $account_title)
    {
        $sql = 'SELECT '.implode(',', self::$account_field).' FROM fantasy_account WHERE user_id = :user_id AND account_title = :account_title LIMIT 1';
        $account_data = Db::findOne($sql, [':user_id' => $user_id, ':account_title' => $account_title]);

        return $account_data;
    }

    /**
     * 保存账号信息
     * 
     * @return integer|bool
     */
    public static function saveAccountData($data = [])
    {
        return Db::insert('fantasy_account', $data);
    }
}
