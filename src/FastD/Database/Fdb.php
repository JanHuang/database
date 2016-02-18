<?php
/**
 * Copyright (c) 2016. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

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

/**
 * Class Fdb
 *
 * @package FastD\Database
 */
class Fdb implements \Iterator, \Countable
{
    const VERSION = '2.0.0';

    /**
     * All database configuration information.
     *
     * @var array
     */
    private $config;

    /**
     * Database connection collection.
     *
     * @var DriverInterface[]
     */
    private $drivers = [];

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @return $this
     */
    public function createPool()
    {
        foreach ($this->config as $name => $value) {
            $this->getDriver($name);
        }

        return $this;
    }

    public function createPdo(array $config)
    {
        return new \PDO(
            sprintf(
                'mysql:host=%s;port=%s;dbname=%s;charset=%s',
                $config['host'],
                $config['port'],
                $config['dbname'],
                $config['charset'] ?? 'utf8'
            ),
            $config['user'],
            $config['pwd']
        );
    }

    /**
     * @param $name
     * @return DriverInterface
     */
    public function getDriver($name)
    {
        if ($this->hasDriver($name)) {
            return $this->drivers[$name];
        }

        /**
         * Anonymous function.
         * Return \PDO.
         */
        $this->setDriver($name, new Driver($this->createPdo($this->config[$name])));

        return $this->drivers[$name];
    }

    /**
     * @param $name
     * @return bool
     */
    public function hasDriver($name)
    {
        return isset($this->drivers[$name]);
    }

    /**
     * @param string $name
     * @param DriverInterface $driverInterface
     * @return $this
     */
    public function setDriver($name, DriverInterface $driverInterface)
    {
        $this->drivers[$name] = $driverInterface;

        return $this;
    }

    /**
     * Return the current element
     *
     * @link  http://php.net/manual/en/iterator.current.php
     * @return DriverInterface Can return any type.
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

    /**
     * Count elements of an object
     * @link http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     * @since 5.1.0
     */
    public function count()
    {
        return count($this->drivers);
    }
}