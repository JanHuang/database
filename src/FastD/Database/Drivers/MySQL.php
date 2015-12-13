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

use FastD\Database\QueryContext\MysqlQueryContext;
use FastD\Database\Drivers\Connection\Connection;

/**
 * Class MySQL
 *
 * @package FastD\Database\Drivers
 */
class MySQL extends DriverAbstract
{
    /**
     * MySQL constructor.
     *
     * @param       $name
     * @param array $config
     */
    public function __construct($name, array $config)
    {
        $this->setName($name);
        $dsn = 'mysql:host=' . $config['database_host'] . ';port=' . $config['database_port'] . ';dbname=' . $config['database_name'];
        $pdo = new \PDO($dsn, $config['database_user'], $config['database_pwd']);
        $pdo->exec('SET NAMES ' . (isset($config['database_charset']) ? $config['database_charset'] : 'utf8'));
        $this->setConnection(new Connection($pdo));
        $this->setContext(new MysqlQueryContext());
    }

    public function where($where)
    {
        // TODO: Implement where() method.
    }

    public function field(array $fields)
    {
        // TODO: Implement field() method.
    }

    public function limit($offset, $limit)
    {
        // TODO: Implement limit() method.
    }

    public function table($name)
    {
        // TODO: Implement table() method.
    }

    public function join($table, $join = 'LEFT')
    {
        // TODO: Implement join() method.
    }

    public function group()
    {
        // TODO: Implement group() method.
    }
}