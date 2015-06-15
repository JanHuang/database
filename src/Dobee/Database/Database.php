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
 * Class DatabaseDriver
 *
 * @package Dobee\Kernel\Configuration\Drivers
 */
class Database
{
    /**
     * Database connection mapping.
     *
     * @var ConnectionInterface[]
     */
    private $mapping = array(
        'mysql' => 'Dobee\\Database\\Connection\\Mysql\\MysqlConnection',
        'mongo' => 'Dobee\\Database\\Connection\\Mysql\\MongoConnection',
        'pgsql' => 'Dobee\\Database\\Connection\\PostgreSQL\\PostgreSQLConnection',
    );

    /**
     * All database configuration information.
     *
     * @var array
     */
    private $config = array();

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
     * @param $name
     * @return bool
     */
    public function getConfig($name)
    {
        return isset($this->config[$name]) ? $this->config[$name] : false;
    }

    /**
     * @param null $connection
     * @return ConnectionInterface
     * @throws ConnectionException
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
     * @param                     $name
     * @param ConnectionInterface $connectionInterface
     * @return $this
     */
    public function setConnection($connection, ConnectionInterface $connectionInterface)
    {
        $this->collections[$connection] = $connectionInterface;

        return $this;
    }

    /**
     * Created new database connection.
     *
     * @param $connection
     * @return ConnectionInterface
     * @throws ConnectionException
     */
    private function createConnection($connection)
    {
        if (false === ($config = $this->getConfig($connection))) {
            throw new ConnectionException(sprintf('Connection type "%s" is undefined.', $connection));
        }

        $connection = new $this->mapping[$config['database_type']]($config);

        $connection->setConnectionName($connection);

        return $connection;
    }
}