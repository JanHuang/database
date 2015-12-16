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
abstract class Entity implements \ArrayAccess
{
    /**
     * Operation DB table name.
     *
     * @var string
     */
    protected $table;

    /**
     * The table table structure.
     *
     * @var array
     */
    protected $structure;

    /**
     * The table all field as field alias.
     *
     * @var array
     */
    protected $fields;

    /**
     * Query result row.
     *
     * @var array
     */
    protected $row = [];

    /**
     * Reflection repository class name.
     *
     * @var string
     */
    protected $repository;

    /**
     * DB driver.
     *
     * @var DriverInterface
     */
    protected $driver;

    /**
     * Table primary name.
     *
     * @var string
     */
    protected $primary = 'id';

    /**
     * Table primary value.
     *
     * @var int|string
     */
    protected $id = null;

    /**
     * @param int $id
     * @param \FastD\Database\Drivers\DriverInterface $driverInterface
     */
    public function __construct($id, \FastD\Database\Drivers\DriverInterface $driverInterface = null)
    {
        $this->id = $id;

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
     * @param DriverInterface $driverInterface
     * @return $this
     */
    public function setDriver(DriverInterface $driverInterface)
    {
        $this->driver = $driverInterface;

        return $this;
    }

    /**
     * @return string
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @return array
     */
    public function getStructure()
    {
        return $this->structure;
    }

    /**
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @return string
     */
    public function getPrimary()
    {
        return $this->primary;
    }

    /**
     * @return string
     */
    public function getRepository()
    {
        if (!($this->repository instanceof Repository)) {
            $this->repository = new $this->repository($this->getDriver());
        }

        return $this->repository;
    }

    /**
     * @param array $row
     * @return $this
     */
    public function setRow(array $row)
    {
        $this->row = $row;

        return $this;
    }

    /**
     * @return array
     */
    public function getRow()
    {
        return $this->row;
    }

    /**
     * @return $this|bool
     */
    public function find()
    {
        $row = $this->driver
            ->table(
                $this->getTable()
            )
            ->field($this->fields)
            ->find([
                $this->primary => $this->id
            ])
        ;

        return false === $row ? false : static::init($this, $row, $this->driver);
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

    /**
     * @param Entity          $entity
     * @param array           $data
     * @param DriverInterface $driverInterface
     * @return Entity
     */
    public static function init(Entity $entity, array $data, DriverInterface $driverInterface)
    {
        $entity->row = $data;

        $entity->setDriver($driverInterface);

        foreach ($entity->getFields() as $field => $name) {
            $method = 'set' . ucfirst($name);
            $entity->$method(isset($data[$name]) ? $data[$name] : null);
        }

        return $entity;
    }

    /**
     * @param array           $data
     * @param DriverInterface $driverInterface
     * @return Entity[]
     */
    public static function initArray(array $data, DriverInterface $driverInterface)
    {
        $entities = [];

        $entity = new static;

        foreach ($data as $row) {
            $entities[] = self::init(clone $entity, $row, $driverInterface);
        }

        return $entities;
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->row[$offset]);
    }

    /**
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->row[$offset];
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->row[$offset] = $value;
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->row[$offset]);
    }
}