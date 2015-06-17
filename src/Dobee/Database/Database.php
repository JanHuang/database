<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/2/8
 * Time: 下午7:08
 * Github: https://www.github.com/janhuang 
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 */

namespace Dobee\Database;

use Dobee\Database\Driver\DriverInterface;
use Dobee\Database\Driver\MysqlDriver;

/**
 * Class DatabaseDriver
 *
 * @package Dobee\Kernel\Configuration\Drivers
 */
class Database
{
    /**
     * All database configuration information.
     *
     * @var Config
     */
    private $config;

    /**
     * Database connection collection.
     *
     * @var array
     */
    private $collections = array();

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = new Config($config);
    }

    /**
     * @param null $connection
     * @return DriverInterface
     */
    public function getConnection($connection = null)
    {
        if ($this->hasConnection($connection)) {
            return $this->collections[$connection];
        }

        return $this
            ->setConnection($connection, $this->createConnection($connection))
            ->getConnection($connection);
    }

    /**
     * @param $connection
     * @return bool
     */
    public function hasConnection($connection)
    {
        return isset($this->collections[$connection]);
    }

    /**
     * @inheritdoc
     *
     * @param                 $connection
     * @param DriverInterface $connection
     * @return $this
     */
    public function setConnection($connection, DriverInterface $driver)
    {
        $this->collections[$connection] = $driver;

        return $this;
    }

    /**
     * Created new database connection.
     *
     * @param $connection
     * @return DriverInterface
     */
    private function createConnection($connection)
    {
        $config = $this->config->createConfig($connection);

        switch ($config->getDatabaseType()) {
            case 'mysql':
            case 'mariadb':
            default:
                $driver = new MysqlDriver($config);
        }

        return $driver;
    }
}