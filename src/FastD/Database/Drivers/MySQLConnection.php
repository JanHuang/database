<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/12/13
 * Time: 下午9:04
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Database\Drivers;

use FastD\Database\Drivers\Connection\Connection;

class MySQLConnection extends Connection
{
    public function __construct(array $config)
    {
        $dsn = 'mysql:host=' . $config['database_host'] . ';port=' . $config['database_port'] . ';dbname=' . $config['database_name'];
        $pdo = new \PDO($dsn, $config['database_user'], $config['database_pwd']);
        $pdo->exec('SET NAMES ' . (isset($config['database_charset']) ? $config['database_charset'] : 'utf8'));
        parent::__construct($pdo);
    }
}