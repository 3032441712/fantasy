<?php
/**
 * MYSQL操作类
 *
 * PHP version 5.4
 *
 * @category Db
 * @package  Db
 * @author   zhaoyan <1210965963@qq.com>
 * @license  https://github.com/3032441712/person/blob/master/LICENSE GNU License
 * @version  GIT: $Id$
 * @link     http://www.168helps.com/blog
 */

namespace Db;

/**
 * Mysql类
 *
 * @category Db
 * @package  Db
 * @author   zhaoyan <1210965963@qq.com>
 * @license  https://github.com/3032441712/person/blob/master/LICENSE GNU License
 * @link     http://www.168helps.com/blog
 */
final class Mysql
{

    /**
     *
     * @var \PDO
     */
    private $dbLink = null;

    /**
     * 实例化数据库
     *
     * @param string $dbhost  MYSQL主机地址
     * @param string $dbport  MYSQL主机端口
     * @param string $dbuser  MYSQL用户
     * @param string $dbpass  MYSQL密码
     * @param string $dbname  MYSQL数据库
     * @param string $charset 数据库编码
     *
     * @return void
     */
    public function __construct($dbhost, $dbport, $dbuser, $dbpass, $dbname, $charset = 'utf8')
    {
        if ($this->dbLink instanceof \PDO == false) {
            $dsn = "mysql:host={$dbhost};port={$dbport};dbname={$dbname}";
            $options = [
                \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES {$charset}",
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
            ];
            $this->dbLink = new \PDO($dsn, $dbuser, $dbpass, $options);
        }
    }

    /**
     * 获取单条数据
     *
     * @param string $sql              执行的sql语句
     * @param array  $input_parameters 预处理数据
     * @param int    $fetch_style      数据检索出来的数据格式
     *
     * @return array
     */
    public function fetchOne($sql, $input_parameters = [], $fetch_style = \PDO::FETCH_ASSOC)
    {
        $statement = $this->query($sql, $input_parameters);
        $data = $statement->fetch($fetch_style);
        $statement->closeCursor();

        return $data;
    }

    /**
     * 插入数据到数据表
     * 
     * @param string $table 数据表
     * @param array  $data  数据
     * 
     * @return int 返回主键
     * @throws \PDOException
     */
    public function insert($table, $data = []) 
    {
        $params = [];
        foreach ($data as $k => $v) {
            $params[':'.$k] = $v;
        }
        $sql = 'INSERT INTO '.$table.' ('.implode(',', array_keys($data)).') VALUES ('.implode(',', array_keys($params)).')';
        $statement = $this->query($sql, $params);
        $statement->closeCursor();

        return $this->getLastInsertId();
    }

    /**
     * 更新数据
     * 
     * @param string $table 数据表
     * @param array  $data  数据
     * 
     * @return int
     * @throws \PDOException
     */
    public function update($table, $data = [], $condition)
    {
        $params = [];
        $set_data = [];
        $row_count = 0;
        $sql = 'UPDATE '.$table.' SET ';
        foreach ($data as $k => $v) {
            $params[':'.$k] = $v;
            $set_data[] = $k.'=:'.$k;
        }
        $sql .= implode(',', $set_data) . $condition;
        $statement = $this->query($sql, $params);
        $row_count = $statement->rowCount();
        $statement->closeCursor();

        return $row_count;
    }

    /**
     * 删除数据
     * 
     * @param string $table     数据表
     * @param string $condition 条件
     * 
     * @return int 语句影响的行数
     * @throws \PDOException
     */
    public function delete($table, $condition)
    {
        $row_count = 0;
        $sql = 'DELETE FROM '.$table.' '.$condition;
        $statement = $this->query($sql);
        $row_count = $statement->rowCount();
        $statement->closeCursor();

        return $row_count;
    }

    /**
     * 获取多条数据
     *
     * @param string $sql              执行的sql语句
     * @param array  $input_parameters 预处理数据
     * @param int    $fetch_style      数据检索出来的数据格式
     *
     * @return array
     * @throws \PDOException
     */
    public function fetchAll($sql, $input_parameters = [], $fetch_style = \PDO::FETCH_ASSOC)
    {
        $data = [];
        $statement = $this->query($sql, $input_parameters);
        $data = $statement->fetchAll($fetch_style);
        $statement->closeCursor();

        return $data;
    }

    /**
     * 返回最后插入数据的主键
     *
     * @return int
     */
    public function getLastInsertId()
    {
        return $this->dbLink->lastInsertId();
    }

    /**
     * 执行SQL语句
     *
     * @param string $sql              执行的SQL语句
     * @param array  $input_parameters 数据参数
     *
     * @return \PDOStatement
     * @throws \PDOException
     */
    public function query($sql, $input_parameters = [])
    {
        $statement = $this->dbLink->prepare($sql);
        foreach ($input_parameters as $k => $v) {
            $data_type = \PDO::PARAM_STR;
            if (is_int($v)) {
                $data_type = \PDO::PARAM_INT;
            } elseif (is_bool($v)) {
                $data_type = \PDO::PARAM_BOOL;
            } elseif (is_null($v)) {
                $data_type = \PDO::PARAM_NULL;
            }
            $statement->bindParam($k, $v, $data_type);
        }
        $statement->execute();

        return $statement;
    }

    /**
     * 开启事务处理
     *
     * @return bool true/false
     */
    public function beginTransaction()
    {
        return $this->dbLink->beginTransaction();
    }

    /**
     * 事物回滚
     *
     * @return bool true/false
     */
    public function rollBack()
    {
        return $this->dbLink->rollBack();
    }

    /**
     * 开启事务后进行提交
     *
     * @return bool true/false
     */
    public function commit()
    {
        return $this->dbLink->commit();
    }

    /**
     * 返回PDO对象
     *
     * @return \PDO
     */
    public function getDbLink()
    {
        return $this->dbLink;
    }

    /**
     * 关闭连接
     *
     * @return void
     */
    public function close()
    {
        $this->dbLink = null;
    }

    /**
     * 析构函数
     *
     * @return void
     */
    public function __destruct()
    {
        $this->close();
    }
}
