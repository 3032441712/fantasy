<?php

namespace Fantasy\Model;

use Fantasy\Service\AccountService;
use Database\Base\Db;
class AccountModel
{
    const ACCOUNT_TITILE_EXISTS = 1504;

    const ACCOUNT_ACCOUNTID_NOT_FOUND = 1506;

    /**
     * 添加账号信息
     * 
     * @param array $data 数据
     * 
     * @return int
     * @throws \Exception
     * @throws \PDOException
     */
    public static function fantasyAccountAdd($data = [])
    {
        try {
            Db::beginTransaction();
            $account_data = AccountService::findAccountInfoByTitle($data['user_id'], $data['account_title'], 0, true);
            if (isset($account_data['account_id'])) {
                throw new \Exception('账号标题已经存在,请重新输入.', self::ACCOUNT_TITILE_EXISTS);
            }

            $account_id = AccountService::saveAccountData($data);
            Db::commit();

            return $account_id;
        } catch (\PDOException $e) {
            Db::rollBack();
            throw new \PDOException($e->getMessage(), $e->getCode());
        } catch (\Exception $e) {
            Db::rollBack();
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    /**
     * 更新账号信息
     * 
     * @param array $data       数据数组
     * @param int   $account_id 账号ID
     * 
     * @return int 影响的行数
     * @throws \PDOException
     * @throws \Exception
     */
    public static function fantasyAccountUpdate($data, $account_id)
    {
        try {
            Db::beginTransaction();
            $account_data = AccountService::findAccountInfoById($account_id, true);
            if (isset($account_data['account_id']) == false) {
                throw new \Exception('没有找到需需要更新的数据.', self::ACCOUNT_ACCOUNTID_NOT_FOUND);
            }

            if (isset($data['account_title'])) {
                $account = AccountService::findAccountInfoByTitle($account_data['user_id'], $data['account_title'], $account_id, true);
                if (isset($account['account_id'])) {
                    throw new \Exception('账号标题已经存在,请重新输入.', self::ACCOUNT_TITILE_EXISTS);
                }
            }
            $data['account_updated'] = isset($data['account_updated']) ? $data['account_updated'] : date('Y-m-d H:i:s');
            $count = AccountService::saveAccountData($data, $account_id);
            Db::commit();

            return $count;
        } catch (\PDOException $e) {
            Db::rollBack();
            throw new \PDOException($e->getMessage(), $e->getCode());
        } catch (\Exception $e) {
            Db::rollBack();
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    /**
     * 根据账号ID查看详情
     * 
     * @param int $account_id 账号ID
     * 
     * @return array
     * @throws \Exception
     */
    public static function fantasyAccountInfo($account_id)
    {
        $account_data = AccountService::findAccountInfoById($account_id);
        if (isset($account_data['account_id']) == false) {
            throw new \Exception('没有找到需需要更新的数据.', self::ACCOUNT_ACCOUNTID_NOT_FOUND);
        }

        return $account_data;
    }

    /**
     * 查看账号列表
     * 
     * @param int $user_id  用户ID
     * @param int $page     当前分页
     * @param int $pagesize 每页显示的数据
     * 
     * @return array
     */
    public static function fantasyAccountList($user_id, $page, $pagesize)
    {
        return AccountService::findAccountAllData(['user_id' => $user_id], $page, $pagesize);
    }
}