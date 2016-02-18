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
use FastD\Database\Drivers\Query\MySQLQueryBuilder;

/**
 * Class Entity
 *
 * @package FastD\Database\ORM
 */
abstract class Entity extends HttpRequestHandle implements \ArrayAccess
{
    const FIELDS = [];
    const ALIAS = [];
    const PRIMARY = '';

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
     * @var array
     */
    protected $condition = null;

    /**
     * @param array             $condition
     * @param DriverInterface $driverInterface
     */
    public function __construct(array $condition = null, DriverInterface $driverInterface)
    {
        $this->condition = $condition;

        $this->setDriver($driverInterface);

        if (null !== $condition) {
            $this->init($this->find());
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
    public function getFields()
    {
        return static::FIELDS;
    }

    /**
     * @return array
     */
    public function getAlias()
    {
        return static::ALIAS;
    }

    /**
     * @return string
     */
    public function getPrimary()
    {
        return static::PRIMARY;
    }

    /**
     * @param array $fields
     * @return array|bool
     */
    public function find(array $fields = [])
    {
        return $this->driver
            ->createQuery(
                MySQLQueryBuilder::factory()
                    ->table($this->getTable())
                    ->where($this->condition)
                    ->fields(array() === $fields ? $this->getAlias() : $fields)
                    ->select()
            )
            ->getQuery()
            ->getOne()
        ;
    }

    /**
     * Save row in database.
     *
     * @return int|bool
     */
    public function save()
    {
        $data = [];
        $values = [];
        foreach ($this->getAlias() as $field => $alias) {
            $method = 'get' . ucfirst($alias);
            $value = $this->$method();
            if (null === $value) {
                continue;
            }
            $data[$field] = ':' . $alias;
            $values[$alias] = $value;
        }

        // update
        if (null !== $this->id) {
            unset($data[$this->getPrimary()], $values[$this->getPrimary()]);
            return $this->driver
                ->createQuery(
                    MySQLQueryBuilder::factory()
                        ->table($this->getTable())
                        ->update($data, [$this->getPrimary() => $this->id,])
                )
                ->setParameter($values)
                ->getQuery()
                ->getAffected()
                ;
        }

        return $this->driver
            ->createQuery(
                MySQLQueryBuilder::factory()
                    ->table($this->getTable())
                    ->insert($data)
            )
            ->setParameter($values)
            ->getQuery()
            ->getId()
            ;
    }

    /**
     * @param array $data
     * @return $this
     */
    protected function init($data)
    {
        $this->row = $data;

        if (false !== $data) {
            foreach ($this->getAlias() as $field => $alias) {
                $method = 'set' . ucfirst($alias);
                $this->$method(isset($data[$alias]) ? $data[$alias] : null);
            }
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