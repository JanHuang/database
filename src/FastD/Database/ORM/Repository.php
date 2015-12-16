<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/3/12
 * Time: 上午11:15
 * Github: https://www.github.com/janhuang 
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 */

namespace FastD\Database\ORM;

use FastD\Database\Drivers\Driver;
use FastD\Database\Drivers\DriverInterface;

/**
 * Class Repository
 *
 * @package FastD\Database\Repository
 */
abstract class Repository
{
    /**
     * @var string
     */
    protected $table;

    /**
     * @var array
     */
    protected $fields;

    /**
     * @var array
     */
    protected $keys;

    /**
     * @var string
     */
    protected $entity;

    /**
     * @var DriverInterface
     */
    protected $driver;

    /**
     * @param DriverInterface $driverInterface
     */
    public function __construct(DriverInterface $driverInterface = null)
    {
        $this->setDriver($driverInterface);
    }

    /**
     * @return DriverInterface
     */
    public function getDriver()
    {
        return $this->driver;
    }

    /**
     * @param DriverInterface|null $driverInterface
     * @return $this
     */
    public function setDriver(DriverInterface $driverInterface = null)
    {
        $this->driver = $driverInterface;

        return $this;
    }

    /**
     * Return mapping database table full name.
     *
     * @return string
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Fetch one row.
     *
     * @param array $where
     * @param array $field
     * @return object The found object.
     */
    public function find(array $where = [], array $field = [])
    {
        return $this->driver
            ->table(
                $this->getTable()
            )
            ->where($where)
            ->field($field)
            ->find()
            ;
    }

    /**
     * Fetch all rows.
     *
     * @param array $where
     * @param array|string $field
     * @return object The found object.
     */
    public function findAll(array $where = [],  array $field = [])
    {
        return $this->driver
            ->table(
                $this->getTable()
            )
            ->where($where)
            ->field($field)
            ->findAll()
        ;
    }

    /**
     * @param array $data
     * @return int|bool
     */
    public function insert(array $data = array())
    {
        return $this->driver->insert($this->getTable(), $data);
    }
    /**
     * @param array $data
     * @param array $where
     * @return int|bool
     */
    public function update(array $data = [], array $where = [])
    {
        return $this->driver->update($this->getTable(), $data, $where);
    }

    /**
     * @param array $where
     * @return int|bool
     */
    public function count(array $where = [])
    {
        return $this->driver->count($this->getTable(), $where);
    }

    /**
     * @param $dql
     * @return Driver
     */
    public function createQuery($dql)
    {
        return $this->driver->createQuery($dql);
    }

    /**
     * @param int  $page
     * @param int  $showList
     * @param int  $showPage
     * @param null $lastId
     * @return \FastD\Database\Pagination\QueryPagination
     */
    public function pagination($page = 1, $showList = 25, $showPage = 5, $lastId = null)
    {
        return $this->driver->pagination($this->getTable(), $page, $showList, $showPage, $lastId);
    }

    /**
     * Return query errors.
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->driver->getErrors();
    }

    /**
     * Return last query log.
     *
     * @return string
     */
    public function getLastQuery()
    {
        return $this->driver->getQueryString();
    }

    /**
     * Return all query logs.
     *
     * @return array
     */
    public function getQueryLogs()
    {
        return $this->driver->getLogs();
    }
}