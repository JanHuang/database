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
abstract class Entity extends HttpRequestHandle implements \ArrayAccess
{
    const FIELDS    = [];
    const ALIAS     = [];
    const PRIMARY   = '';

    /**
     * Operation DB table name.
     *
     * @var string
     */
    protected $table;

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
     * Table primary value.
     *
     * @var int|string
     */
    protected $id = null;

    /**
     * @param int $id
     * @param \FastD\Database\Drivers\DriverInterface $driverInterface
     */
    public function __construct($id = null, \FastD\Database\Drivers\DriverInterface $driverInterface = null)
    {
        $this->id = $id;

        $this->setDriver($driverInterface);

        if (null === $id) {
            $this->find();
        }
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
    public function setDriver(DriverInterface $driverInterface = null)
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
    public function getAlias()
    {
        return static::ALIAS;
    }

    /**
     * @return array
     */
    public function getFields()
    {
        return static::FIELDS;
    }

    /**
     * @return string
     */
    public function getPrimary()
    {
        return static::PRIMARY;
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
        $this->init($row);

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
     * @param array $fields
     * @return $this|bool
     */
    public function find(array $fields = [])
    {
        if (null === $this->getRow()) {
            $row = $this->driver
                ->table(
                    $this->getTable()
                )
                ->field(
                    array() === $fields ? $this->getAlias() : $fields
                )
                ->find([
                    $this->getPrimary()=> $this->id
                ])
            ;

            $this->init($row);
        }

        return $this->row;
    }

    /**
     * Save row in database.
     * @return int|bool
     */
    public function save()
    {
        $data = [];
        $values = [];
        foreach ($this->getFields() as $field => $alias) {
            $method = 'get' . ucfirst($alias);
            $value = $this->$method();
            if (null === $value) {
                continue;
            }
            $data[$field] = ':' . $field;
            $values[$field] = $value;
        }

        $where = [];

        if (null !== $this->id) {
            $where[$this->getPrimary()] = $this->id;
        }

        $id = $this->driver
            ->table(
                $this->getTable()
            )
            ->save($data, $where, $values)
        ;

        unset($data, $where, $value);

        if (null === $this->id) {
            $this->id = $id;
        }

        return $id;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function init(array $data)
    {
        $this->row = $data;

        foreach ($this->getFields() as $field => $alias) {
            $method = 'set' . ucfirst($alias);
            $this->$method(isset($data[$alias]) ? $data[$alias] : null);
        }

        return $this;
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