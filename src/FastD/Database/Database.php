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

use FastD\Database\Connection\ConnectionInterface;
use FastD\Database\Connection\Mysql\MysqlConnection;

/**
 * Class Database
 *
 * @package FastD\Database
 */
class Database implements \Iterator
{
    /**
     * All database configuration information.
     *
     * @var array
     */
    private $config;

    /**
     * Database connection collection.
     *
     * @var ConnectionInterface[]
     */
    private $connections = [];

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @param       $name
     * @param array $config
     * @return Connection
     */
    public function addConnection($name, array $config)
    {
        if (!isset($config['database_type'])) {
            throw new \RuntimeException('Database type is undefined.');
        }

        switch ($config['database_type']) {
            case 'mysql':
            case 'maraidb':
            default:
                $connection = new MysqlConnection($config);
        }

        $connection->setName($name);

        $this->setConnection($name, $connection);

        return $connection;
    }

    /**
     * @param null $connection
     * @return ConnectionInterface
     */
    public function getConnection($connection = null)
    {
        if ($this->hasConnection($connection)) {
            return $this->connections[$connection];
        }

        return $this->addConnection($connection, $this->config[$connection]);
    }

    /**
     * @param $connection
     * @return bool
     */
    public function hasConnection($connection)
    {
        return isset($this->connections[$connection]);
    }

    /**
     * @inheritdoc
     *
     * @param        $connection
     * @param ConnectionInterface $connectionInterface
     * @return $this
     */
    public function setConnection($connection, ConnectionInterface $connectionInterface)
    {
        $this->connections[$connection] = $connectionInterface;

        return $this;
    }

    /**
     * Return the current element
     *
     * @link  http://php.net/manual/en/iterator.current.php
     * @return ConnectionInterface Can return any type.
     * @since 5.0.0
     */
    public function current()
    {
        return current($this->connections);
    }

    /**
     * Move forward to next element
     *
     * @link  http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next()
    {
        next($this->connections);
    }

    /**
     * Return the key of the current element
     *
     * @link  http://php.net/manual/en/iterator.key.php
     * @return string scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        return key($this->connections);
    }

    /**
     * Checks if current position is valid
     *
     * @link  http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     *        Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid()
    {
        return isset($this->connections[$this->key()]);
    }

    /**
     * Rewind the Iterator to the first element
     *
     * @link  http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind()
    {
        reset($this->connections);
    }
}