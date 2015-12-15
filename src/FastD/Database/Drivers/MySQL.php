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

use FastD\Database\Drivers\Query\MySQLQueryBuilder;

/**
 * Class MySQL
 *
 * @package FastD\Database\Drivers
 */
class MySQL extends Driver
{
    /**
     * MySQL constructor.
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $dsn = 'mysql:host=' . $config['database_host'] . ';port=' . $config['database_port'] . ';dbname=' . $config['database_name'];
        $this->setPDO(new \PDO($dsn, $config['database_user'], $config['database_pwd']));
        $this->setQueryBuilder(new MySQLQueryBuilder());
    }
}