<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/2/8
 * Time: 上午12:03
 * Github: https://www.github.com/janhuang 
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 */

namespace FastD\Database\Connection\Mysql;

use FastD\Database\Connection\Connection;

/**
 * Class MysqlConnection
 *
 * @package FastD\Kernel\Configuration\pdos\Db\Mysql
 */
class MysqlConnection extends Connection
{
    /**
     * MysqlConnection constructor.
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $dsn = 'mysql:host=' . $config['database_host'] . ';port=' . $config['database_port'] . ';dbname=' . $config['database_name'];
        $this->pdo = new \PDO($dsn, $config['database_user'], $config['database_pwd']);
        $this->pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
        $this->pdo->exec('SET NAMES ' . (isset($config['database_charset']) ? $config['database_charset'] : 'utf8'));
        $this->setQueryContext(new MysqlQueryContext());
    }
}