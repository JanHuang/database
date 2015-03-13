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

use Dobee\Database\Connection\ConnectionException;
use Dobee\Database\Connection\ConnectionInterface;

/**
 * Class Driver
 *
 * @package Dobee\Kernel\Configuration\Drivers
 */
class DriverManager
{
    /**
     * @var array
     */
    private $mapping = array(
        'mysql' => 'Dobee\\Database\\Mysql\\MysqlConnection',
        'mongo' => '',
        'sqlit' => '',
    );

    /**
     * @var array
     */
    private $collections = array();

    /**
     * @var array
     */
    private $config = array();

    /**
     * @param array $config
     */
    public function __construct($config = array())
    {
        $this->config = $config;
    }

    /**
     * @param null $connection
     * @return ConnectionInterface
     * @throws ConnectionException
     */
    public function getConnection($connection = null)
    {
        if (isset($this->collections[$connection])) {
            return $this->collections[$connection];
        }

        if (null === $connection) {
            if (!isset($this->config['default_connection'])) {
                throw new ConnectionException(sprintf('Default connection is undefined.'));
            }

            $connection = $this->config['default_connection'];
        }

        $this->setConnection($connection, $this->createConnection($connection));

        return $this->collections[$connection];
    }

    /**
     * @param                     $connection
     * @param ConnectionInterface $connectionInterface
     * @return $this
     */
    public function setConnection($connection, ConnectionInterface $connectionInterface)
    {
        $this->collections[$connection] = $connectionInterface;

        return $this;
    }

    /**
     * @param $connection
     * @return ConnectionInterface
     * @throws ConnectionException
     */
    private function createConnection($connection)
    {
        if (!isset($this->config[$connection])) {
            throw new ConnectionException(sprintf('Connection type "%s" is undefined.', $connection));
        }

        $config = $this->config[$connection];

        $connection = new $this->mapping[$config['database_type']?:'mysql']($config);

        $connection->setConnectionName($connection);

        return $connection;
    }
}