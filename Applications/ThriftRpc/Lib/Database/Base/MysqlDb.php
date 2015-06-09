<?php

namespace Database\Base;

class MysqlDb implements DbInterface
{
    /**
     * @var \PDO 数据库采用PDO方式连接
     */
    private $_link = null;

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
        if ($this->_link instanceof \PDO == false) {
            $dsn = "mysql:host={$dbhost};port={$dbport};dbname={$dbname}";
            $options = array(
                \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES {$charset}",
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
            );
            $this->_link = new \PDO($dsn, $dbuser, $dbpass, $options);
        }
    }

    public function query($sql, $params = [])
    {
        $statement = $this->_link->prepare($sql);
        foreach ($params as $k => $v) {
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

    public function findOne($sql, $params = [], $fetch_style = \PDO::FETCH_ASSOC)
    {
        $statement = $this->query($sql, $params);
        $data = $statement->fetch($fetch_style);
        $statement->closeCursor();

        return $data;
    }

    public function findAll($sql, $params = [], $fetch_style = \PDO::FETCH_ASSOC)
    {
        $statement = $this->query($sql, $params);
        $data = $statement->fetchAll($fetch_style);
        $statement->closeCursor();

        return $data;
    }

    public function insert($table, $data = [])
    {
        $params = [];
        foreach ($data as $k => $v) {
            $params[':'.$k] = $v;
        }

        $sql = 'INSERT INTO '.$table.'('.implode(',', array_keys($data)).') VALUES ('.implode(',', array_keys($params)).')';
        $statement = $this->query($sql, $params);
        $statement->closeCursor();

        return $this->getLastInsertId();
    }

    public function update($table, $data = [], $condtion)
    {
        
    }

    public function getLastInsertId()
    {
        return $this->_link->lastInsertId();
    }

    public function exec($sql)
    {
        return $this->_link->exec($sql);
    }

    public function beginTransaction($level = 0)
    {
        $this->_link->beginTransaction();
    }

    public function rollBack()
    {
        $this->_link->rollBack();
    }

    public function commit()
    {
        $this->_link->commit();
    }

    public function __destruct()
    {
        $this->_link = null;
    }
}
