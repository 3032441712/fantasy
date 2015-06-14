<?php

namespace Fantasy\Service;

use Database\Base\Db;
class AccountService
{
    /**
     * @var array 定义数据字段
     */
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
    public static function findAccountInfoById($account_id, $trans = false)
    {
        $sql = 'SELECT '.implode(',', self::$account_field).' FROM fantasy_account WHERE account_id = :account_id LIMIT 1';
        if ($trans) {
            $sql .= ' FOR UPDATE';
        }
        $account_data = Db::findOne($sql, [':account_id' => $account_id]);

        return $account_data;
    }

    /**
     * 根据账号标题取得账号信息
     * 
     * @param int    $user_id       用户ID
     * @param string $account_title 账号标题
     * @param int    $account_id    账号ID,传人该参数,及不包含该账号ID的数据
     * 
     * @return array
     */
    public static function findAccountInfoByTitle($user_id, $account_title, $account_id = 0, $trans = false)
    {
        $sql = 'SELECT '.implode(',', self::$account_field).' FROM fantasy_account WHERE user_id = :user_id AND account_title = :account_title';
        if ($account_id > 0) {
            $sql .= ' AND account_id <> '.intval($account_id);
        }
        $account_data = Db::findOne($sql.' LIMIT 1'.($trans ? ' FOR UPDATE' : ''), [':user_id' => $user_id, ':account_title' => $account_title]);

        return $account_data;
    }

    /**
     * 保存账号信息
     * 
     * @param array $data       数据
     * @param int   $account_id 账号ID
     * 
     * @return integer|bool
     */
    public static function saveAccountData($data = [], $account_id = 0)
    {
        // 去除不存在的字段更新
        foreach ($data as $k => $v) {
            if (in_array($k, self::$account_field) == false) {
                unset($data[$k]);
            }
        }

        if ($account_id == 0) {
            return Db::insert('fantasy_account', $data);
        } else {
            return Db::update('fantasy_account', $data, 'WHERE account_id='.intval($account_id));
        }
    }

    public static function findAccountAllData($condition = [], $page = 1, $pagesize = 25, $orderby = 'account_created DESC')
    {
        $params = [];
        $sql_params = [];
        $sql = 'SELECT {FIELD} FROM fantasy_account WHERE 1=1';
        foreach ($condition as $k => $v) {
            $sql_params[] = $k.'=:'.$k;
            $params[':'.$k] = $v;
        }

        if (count($sql_params)) {
            $sql .= ' AND '.implode(' AND ', $sql_params);
        }

        $account_count = Db::findOne(str_replace('{FIELD}', 'COUNT(1) as count', $sql), $params);
        return [
            'count' => $account_count['count'],
            'account' => Db::findAll(str_replace('{FIELD}', implode(',', self::$account_field), $sql).' ORDER BY '.$orderby.' LIMIT '.($page-1)*$pagesize.','.$pagesize, $params)
        ];
    }
}
