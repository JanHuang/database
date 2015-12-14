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
     * @var mixed
     */
    protected $primary_key;

    /**
     * @var DriverInterface
     */
    protected $driver;

    /**
     * Entity constructor.
     *
     * @param                 $primaryKey
     * @param DriverInterface $driverInterface
     */
    public function __construct($primaryKey, DriverInterface $driverInterface)
    {
        $this->primary_key = $primaryKey;

        $this->setDriver($driverInterface);
    }

    public function getPrimaryKey()
    {

    }

    public function getId()
    {}

    public function setDriver(DriverInterface $driverInterface)
    {

    }

    /**
     * Save row in database.
     */
    public function flush()
    {}

    /**
     * Remove row in database.
     */
    public function remove()
    {}
}