<?php
namespace Database\Base;

interface DbInterface
{
    /**
     * 预处理SQL部分
     * 
     * @param string $sql    SQL 语句
     * @param array  $params 参数数组
     * 
     * @return \PDOStatement
     */
    public function query($sql, $params = []);

    /**
     * 查找单条数据
     *
     * @param string $sql    数据字符串
     * @param array  $params 参数
     *
     * @return array
     */
    public function findOne($sql, $params = [], $fetch_style = \PDO::FETCH_ASSOC);

    /**
     * 查找全部数据
     * 
     * @param string $sql    数据字符串
     * @param array  $params 参数
     * 
     * @return array
     */
    public function findAll($sql, $params = [], $fetch_style = \PDO::FETCH_ASSOC);

    /**
     * 插入数据
     * 
     * @param string $table 表名称
     * @param array  $data  数据
     * 
     * @return int 返回主键
     */
    public function insert($table, $data = []);

    /**
     * 更新表数据
     * 
     * @param string $table    表名称
     * @param array  $data     要更新的数据
     * @param string $condtion 条件
     * 
     * @return int 影响数据的行数
     */
    public function update($table, $data = [], $condtion);

    /**
     * 获取插入数据的主键ID
     * 
     * @return int
     */
    public function getLastInsertId();

    /**
     * 执行一条SQL语句
     * 
     * @param string $sql
     * 
     * @return int 影响的行数
     * @throws \PDOException
     */
    public function exec($sql);

    /**
     * 开启事务
     * 
     * @param int $level 事务级别
     * 
     * @return void
     * @throws \PDOException
     */
    public function beginTransaction($level = 0);

    /**
     * 事务回滚
     * 
     * @return void
     * @throws \PDOException
     */
    public function rollBack();

    /**
     * 提交事务
     * 
     * @return void
     * @throws \PDOException
     */
    public function commit();
}
