<?php
/**
 * This file is part of workerman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link http://www.workerman.net/
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
use Workerman\Worker;
require_once __DIR__ . '/../../Workerman/Autoloader.php';
require_once __DIR__ . '/ThriftWorker.php';

// 引入配置文件
require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'config.php');

$worker = new ThriftWorker('tcp://0.0.0.0:9090');
$worker->count = 2;
$worker->class = 'UserService';

$worker = new ThriftWorker('tcp://0.0.0.0:9091');
$worker->count = 2;
$worker->class = 'AccountService';


// 如果不是在根目录启动，则运行runAll方法
if(!defined('GLOBAL_START'))
{
    Worker::runAll();
}
