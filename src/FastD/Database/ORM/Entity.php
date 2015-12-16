<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/12/12
 * Time: 下午12:01
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Database\ORM;

use FastD\Database\Drivers\DriverInterface;

/**
 * Class Entity
 *
 * @package FastD\Database\ORM
 */
class Entity
{
    /**
     * @var string
     */
    protected $table;

    /**
     * @var string|int
     */
    protected $primary_key;

    /**
     * @var DriverInterface
     */
    protected $driver;

    /**
     * @return DriverInterface
     */
    public function getDriver()
    {
        return $this->driver;
    }

    /**
     * @param DriverInterface $driverInterface
     * @return $this
     */
    public function setDriver(DriverInterface $driverInterface)
    {
        $this->driver = $driverInterface;

        return $this;
    }

    public function getFields()
    {

    }

    /**
     * @return array|bool
     */
    public function find()
    {

    }

    /**
     * Save row in database.
     * @return int|bool
     */
    public function save()
    {}

    /**
     * Remove row in database.
     *
     * @return int|bool
     */
    public function remove()
    {}
}