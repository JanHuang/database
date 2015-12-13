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
    private $drivers = [];

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function getDriver($name)
    {
        if ($this->hasDriver($name)) {
            return $this->drivers[$name];
        }

        return $this->addDriver($name, $this->config[$name]);
    }

    public function hasDriver($name)
    {
        return isset($this->drivers[$name]);
    }

    public function setDriver($name, ConnectionInterface $connectionInterface)
    {
        $this->drivers[$name] = $connectionInterface;

        return $this;
    }

    public function addDriver($name, array $config)
    {
        if (!isset($config['database_type'])) {
            throw new \RuntimeException('Database type is undefined.');
        }

        switch ($config['database_type']) {
            case 'mysql':
            case 'mariadb':
            default:
                $connection = new MysqlConnection($config);
        }

        $connection->setName($name);

        $this->setDriver($name, $connection);

        return $connection;
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
        return current($this->drivers);
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
        next($this->drivers);
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
        return key($this->drivers);
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
        return isset($this->drivers[$this->key()]);
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
        reset($this->drivers);
    }
}