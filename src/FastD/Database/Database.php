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
use FastD\Database\Query\QueryContext;

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
     * @var Config
     */
    private $config;

    /**
     * Database connection collection.
     *
     * @var ConnectionInterface
     */
    private $collections = [];

    private $queryContext;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;

        $this->queryContext = new QueryContext();
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
            ->getConnection($connection)
            ;
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

    /**
     * Return the current element
     *
     * @link  http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current()
    {
        // TODO: Implement current() method.
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
        // TODO: Implement next() method.
    }

    /**
     * Return the key of the current element
     *
     * @link  http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        // TODO: Implement key() method.
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
        // TODO: Implement valid() method.
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
        // TODO: Implement rewind() method.
    }
}