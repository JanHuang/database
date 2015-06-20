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

namespace FastD\Database;

use FastD\Database\Driver\Driver;

/**
 * Class DatabaseDriver
 *
 * @package FastD\Kernel\Configuration\Drivers
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
        $this->config = $config;
    }

    /**
     * @param null $connection
     * @return Driver
     */
    public function getConnection($connection = null)
    {
        if ($this->hasConnection($connection)) {
            return $this->collections[$connection];
        }

        $config = new Config($this->config[$connection]);

        return $this
            ->setConnection($connection, new Driver($config))
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
     * @param        $connection
     * @param Driver $driver
     * @return $this
     */
    public function setConnection($connection, Driver $driver)
    {
        $this->collections[$connection] = $driver;

        return $this;
    }
}