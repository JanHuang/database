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

use FastD\Database\ORM\Params\Bind;
use FastD\Database\Query\QueryBuilder;

/**
 * Class Repository
 *
 * @package FastD\Database\Repository
 */
abstract class Model
{
    use Bind;
    
    const FIELDS = [];
    const ALIAS = [];
    const PRIMARY = '';
    const TABLE = '';

    /**
     * @var string
     */
    protected $entity;

    /**
     * @var DriverInterface
     */
    protected $driver;

    /**
     * @var QueryBuilder
     */
    protected $query_builder;

    /**
     * @param DriverInterface $driverInterface
     */
    public function __construct(DriverInterface $driverInterface = null)
    {
        $this->setDriver($driverInterface);

        $this->createQueryBuilder();
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
     * @return string
     */
    public function getPrimary()
    {
        return static::PRIMARY;
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
                $this->query_builder
                    ->where($where)
                    ->fields(array() === $field ? $this->getAlias() : $field)
                    ->select()
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
                $this->query_builder
                    ->where($where)
                    ->fields(array() === $field ? $this->getAlias() : $field)
                    ->select()
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
                    $this->query_builder
                        ->insert(array() === $data ? $this->data : $data)
                )
                ->setParameter([] === $params ? $this->params : $params)
                ->execute()
                ->getId();
        }

        return $this
            ->createQuery(
                $this
                    ->query_builder
                    ->update(array() === $data ? $this->data : $data, $where)
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
        return (int)$this->where($where)->find(['count(1)' => 'total'])['total'];
    }

    /**
     * @param array $orderBy
     * @return $this
     */
    public function orderBy(array $orderBy)
    {
        $this->query_builder->orderBy($orderBy);

        return $this;
    }

    /**
     * @param array $where
     * @return $this
     */
    public function where(array $where = [])
    {
        $this->query_builder->where($where);

        return $this;
    }

    /**
     * @param $table
     * @param null $alias
     * @return $this
     */
    public function from($table, $alias = null)
    {
        $this->query_builder->from($table, $alias);

        return $this;
    }

    /**
     * @param null $limit
     * @param null $offset
     * @return $this
     */
    public function limit($limit = null, $offset = null)
    {
        $this->query_builder->limit($limit, $offset);

        return $this;
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
        return $this->driver->getError();
    }

    /**
     * @return array
     */
    public function getLogs()
    {
        return $this->query_builder->getLogs();
    }

    /**
     * @return $this
     */
    public function createQueryBuilder()
    {
        if (null === $this->query_builder) {
            $this->query_builder = Mysql::singleton()->from($this->getTable());
        }

        return $this->query_builder;
    }

    /**
     * @param      $page
     * @param int  $showList
     * @param int  $showPage
     * @param null $lastId
     * @return QueryPagination
     */
    public function pagination($page = 1, $showList = 25, $showPage = 5, $lastId = null)
    {
        return new QueryPagination($this, $page, $showList, $showPage, $lastId);
    }
}