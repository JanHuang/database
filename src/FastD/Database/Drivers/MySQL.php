<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/12/13
 * Time: 上午11:10
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Database\Drivers;

use FastD\Database\Connection\Connection;

class MySQL implements DriverInterface
{
    protected $connection;

    protected $context;

    public function __construct($name, array $config)
    {
        $dsn = 'mysql:host=' . $config['database_host'] . ';port=' . $config['database_port'] . ';dbname=' . $config['database_name'];
        $pdo = new \PDO($dsn, $config['database_user'], $config['database_pwd']);
        $pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
        $pdo->exec('SET NAMES ' . (isset($config['database_charset']) ? $config['database_charset'] : 'utf8'));
        $this->connection = new Connection();
        $this->connection->setPDO($pdo);
        unset($pdo);
    }
}