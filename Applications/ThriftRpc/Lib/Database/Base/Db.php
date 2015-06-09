<?php
namespace Database\Base;

class Db
{
    /**
     * 实例化 MysqlDb
     *
     * @var MysqlDb
     */
    private static $link = null;

    /**
     * 获取数据类库对象
     *
     * @return Mysql
     */
    private static function getLink()
    {
        if (self::$link instanceof MysqlDb == false) {
            self::$link = new MysqlDb(DBHOST, DBPORT, DBUSER, DBPASS, DBNAME);
        }

        return self::$link;
    }

    /**
     * 静态魔术方法
     *
     * @param string $name 调用的方法名
     * @param string $args 方法的参数
     *
     * @return void
     */
    public static function __callStatic($name, $args)
    {
        $callback = array(
            self::getLink(),
            $name
        );

        return call_user_func_array($callback, $args);
    }
}