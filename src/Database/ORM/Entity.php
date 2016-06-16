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

use FastD\Database\Params\Bind;
use FastD\Database\Drivers\DriverInterface;
use FastD\Database\Query\QueryBuilder;

/**
 * Class Entity
 *
 * @package FastD\Database\ORM
 */
abstract class Entity implements \ArrayAccess
{
    use Bind;
    
    const FIELDS = [];
    const ALIAS = [];
    const TABLE = null;

    /**
     * Query result row.
     *
     * @var array
     */
    protected $row = [];

    /**
     * DB driver.
     *
     * @var
     */
    protected $driver;

    /**
     * Table primary value.
     *
     * @var array
     */
    protected $condition = null;

    /**
     * @var QueryBuilder
     */
    protected $queryBuilder;

    /**
     * Entity constructor.
     * @param array|null $condition
     * @param DriverInterface|null $driverInterface
     */
    public function __construct(array $condition = null, DriverInterface $driverInterface = null)
    {
        $this->condition = $condition;

        $this->driver = $driverInterface;

        if (null !== $condition) {
            $this->row = $this->find();
            foreach ($this->getAlias() as $field => $alias) {
                $method = 'set' . ucfirst($alias);
                $this->$method(isset($this->row[$alias]) ? $this->row[$alias] : null);
            }
        }


    }

    /**
     * @return string
     */
    public function getTable()
    {
        return static::TABLE;
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
     * @return QueryBuilder
     */
    public function createQueryBuilder()
    {
        return $this->driver->getQueryBuilder();
    }

    /**
     * @param array $where
     * @param array|null $fields
     * @return array|bool
     */
    public function find(array $where = [], array $fields = null)
    {
        return $this->driver
            ->query(
                $this->createQueryBuilder()
                    ->where($where)
                    ->fields($fields ?? $this->getAlias())
                    ->select()
            )
            ->execute()
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
        if (null !== $this->condition) {
            return $this->driver
                ->query($this->createQueryBuilder()->update($data, $this->condition))
                ->setParameter($values)
                ->execute()
                ->getAffected()
                ;
        }

        return $this->driver
            ->query($this->createQueryBuilder()->insert($data))
            ->setParameter($values)
            ->execute()
            ->getId()
            ;
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

    /**
     * @return string
     */
    public function toSerialize()
    {
        return serialize($this->row);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->row;
    }

    /**
     * @return string
     */
    public function toJson()
    {
        return json_encode($this->row, JSON_UNESCAPED_UNICODE);
    }
}