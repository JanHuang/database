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

use FastD\Database\Drivers\DriverInterface;
use FastD\Database\ORM\Params\Bind;
use FastD\Database\Pagination\Pagination;
use FastD\Database\Query\QueryBuilder;

/**
 * Class Model
 * @package FastD\Database\ORM
 */
abstract class Model
{
    use Bind;
    
    const FIELDS = [];
    const ALIAS = [];
    const TABLE = '';

    /**
     * @var DriverInterface
     */
    protected $driver;

    /**
     * @param DriverInterface $driverInterface
     */
    public function __construct(DriverInterface $driverInterface)
    {
        $this->driver = $driverInterface;
    }

    /**
     * @return DriverInterface
     */
    public function getDriver()
    {
        return $this->driver;
    }

    /**
     * @return QueryBuilder
     */
    public function getQueryBuilder()
    {
        return $this->driver->getQueryBuilder();
    }

    /**
     * Return mapping database table full name.
     *
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
     * Fetch one row.
     *
     * @param array $where
     * @param array $field
     * @return array The found object.
     */
    public function find(array $where = [], array $field = [])
    {
        return $this
            ->createQuery(
                $this->getQueryBuilder()
                    ->select(array() === $field ? $this->getAlias() : $field)
                    ->from($this->getTable())
                    ->where($where)
            )
            ->execute()
            ->getOne()
            ;
    }

    /**
     * Fetch all rows.
     *
     * @param array $where
     * @param array|string $field
     * @return array The found object.
     */
    public function findAll(array $where = [], array $field = [])
    {
        return $this
            ->createQuery(
                $this->getQueryBuilder()
                    ->select(array() === $field ? $this->getAlias() : $field)
                    ->from($this->getTable())
                    ->where($where)
            )
            ->execute()
            ->getAll()
            ;
    }

    /**
     * Save row into table.
     *
     * @param array $data
     * @param array $where
     * @param array $params
     * @return bool|int
     */
    public function save(array $data = [], array $where = [], array $params = [])
    {
        if (empty($where)) {
            return $this
                ->createQuery(
                    $this->getQueryBuilder()
                        ->insert(array() === $data ? $this->data : $data)
                        ->from($this->getTable())
                )
                ->setParameter([] === $params ? $this->params : $params)
                ->execute()
                ->getId();
        }

        return $this
            ->createQuery(
                $this
                    ->getQueryBuilder()
                    ->update(array() === $data ? $this->data : $data)
                    ->from($this->getTable())
                    ->where($where)
            )
            ->setParameter([] === $params ? $this->params : $params)
            ->execute()
            ->getAffected()
            ;
    }

    /**
     * @param array $where
     * @return int|bool
     */
    public function count(array $where = [])
    {
        return (int) $this
            ->createQuery(
                $this->getQueryBuilder()
                    ->select(['count(1)' => 'total'])
                    ->from($this->getTable())
                    ->where($where)
            )
            ->execute()
            ->getOne('total')
            ;
    }

    /**
     * @param int $page
     * @param int $showList
     * @param int $showPage
     * @return Pagination
     */
    public function pagination($page = 1, $showList = 25, $showPage = 5)
    {
        return new Pagination($this, $page, $showList, $showPage);
    }

    /**
     * @param array $orderBy
     * @return $this
     */
    public function orderBy(array $orderBy)
    {
        $this->getQueryBuilder()->orderBy($orderBy);

        return $this;
    }

    /**
     * @param array $where
     * @return $this
     */
    public function where(array $where = [])
    {
        $this->getQueryBuilder()->where($where);

        return $this;
    }
    
    /**
     * @param null $limit
     * @param null $offset
     * @return $this
     */
    public function limit($limit = null, $offset = null)
    {
        $this->getQueryBuilder()->limit($limit, $offset);

        return $this;
    }

    /**
     * @param callable $callable
     * @return mixed
     */
    public function transaction(callable $callable)
    {
        return $this->getDriver()->transaction($callable);
    }

    /**
     * @param string $sql
     * @return DriverInterface
     */
    public function createQuery($sql)
    {
        return $this->driver->query($sql);
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
     * @return array
     */
    public function getLogs()
    {
        return $this->driver->getLogs();
    }
}