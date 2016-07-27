<?php
/**
 *
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2016
 *
 * @link      https://www.github.com/janhuang
 * @link      http://www.fast-d.cn/
 */

namespace FastD\Database\ORM;

use FastD\Database\ORM\Params\Bind;
use FastD\Database\Drivers\DriverInterface;
use FastD\Database\Query\QueryBuilder;

/**
 * Class Entity
 * @package FastD\Database\ORM
 */
abstract class Entity
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
     * Entity constructor.
     *
     * @param DriverInterface|null $driverInterface
     * @param array|null $condition
     */
    public function __construct(DriverInterface $driverInterface, array $condition = null)
    {
        $this->condition = $condition;

        $this->driver = $driverInterface;

        if (null !== $condition) {
            $this->bindParams($condition);
            $this->row = $this->find($this->condition, $this->getAlias());
        }
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->driver->getErrors();
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
    public function getQueryBuilder()
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
        $row = $this->driver
            ->query(
                $this->getQueryBuilder()
                    ->select($fields ?? $this->getAlias())
                    ->from($this->getTable())
                    ->where($where)
            )
            ->execute()
            ->getOne();

        if (!empty($row)) {
            foreach ($this->getAlias() as $field => $alias) {
                $method = 'set' . ucfirst($alias);
                $this->$method(isset($row[$alias]) ? $row[$alias] : null);
            }
            $this->row = $row;
        }

        return $row;
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

        if (null !== $this->condition && !empty($this->row)) {
            $id = $this->driver
                ->query(
                    $this
                        ->getQueryBuilder()
                        ->update($data)
                        ->from($this->getTable())
                        ->where($this->condition)
                )
                ->setParameter($values)
                ->execute()
                ->getAffected();
        } else {
            $id = $this->driver
                ->query(
                    $this
                        ->getQueryBuilder()
                        ->insert($data)
                        ->from($this->getTable())
                )
                ->setParameter($values)
                ->execute()
                ->getId();
            if (method_exists($this, 'setId')) {
                $this->setId($id);
            }
        }

        if (!empty($id)) {
            foreach ($this->getAlias() as $alias) {
                $this->row[$alias] = $this->$alias;
            }
        }

        return $id;
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
        return json_encode($this->row, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
    }
}