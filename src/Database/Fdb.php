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

use FastD\Database\Drivers\DriverInterface;
use FastD\Database\Drivers\MySQLDriver;
use Iterator;
use Countable;

/**
 * Class Database
 *
 * @package FastD\Database
 */
class Fdb implements Iterator, Countable
{
    const VERSION = '2.0.0';

    protected $maps = [
        'mysql' => MySQLDriver::class
    ];

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
        $config = $this->config[$name];

        $driver = $this->maps[$config['database_type'] ?? 'mysql'];

        $this->setDriver($name, new $driver($config));

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