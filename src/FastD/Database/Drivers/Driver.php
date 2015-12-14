<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/12/13
 * Time: 下午8:20
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Database\Drivers;

use FastD\Database\Drivers\QueryContext\QueryContextInterface;

/**
 * Class DriverAbstract
 *
 * @package FastD\Database\Drivers
 */
abstract class Driver implements DriverInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var \PDO
     */
    protected $pdo;

    /**
     * @var QueryContextInterface
     */
    protected $queryContext;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return \PDO
     */
    public function getPDO()
    {
        return $this->pdo;
    }

    /**
     * @param \PDO $PDO
     * @return $this
     */
    public function setPDO(\PDO $PDO)
    {
        $this->pdo = $PDO;

        return $this;
    }

    /**
     * @return QueryContextInterface
     */
    public function getQueryContext()
    {
        return $this->queryContext;
    }

    /**
     * @param QueryContextInterface $context
     * @return $this
     */
    public function setQueryContext(QueryContextInterface $context)
    {
        $this->queryContext = $context;

        return $this;
    }

    /**
     * Query select where condition.
     *
     * @param array $where
     * @return DriverInterface
     */
    public function where(array $where)
    {
        $this->queryContext->where($where);

        return $this;
    }

    /**
     * Query fields.
     *
     * @param array $field
     * @return DriverInterface
     */
    public function field(array $field = ['*'])
    {
        $this->queryContext->field($field);

        return $this;
    }

    /**
     * Select join.
     *
     * @param        $table
     * @param        $on
     * @param string $type
     * @return DriverInterface
     */
    public function join($table, $on, $type = 'LEFT')
    {
        $this->queryContext->join($table, $on, $type);

        return $this;
    }

    /**
     * Select to table name.
     *
     * @param $table
     * @return DriverInterface
     */
    public function table($table)
    {
        $this->queryContext->table($table);

        return $this;
    }

    /**
     * @param $offset
     * @param $limit
     * @return DriverInterface
     */
    public function limit($offset, $limit)
    {
        $this->queryContext->limit($offset, $limit);

        return $this;
    }

    /**
     * @param array $groupBy
     * @return DriverInterface
     */
    public function groupBy(array $groupBy)
    {
        $this->queryContext->groupBy($groupBy);

        return $this;
    }

    /**
     * @param array $orderBy
     * @return DriverInterface
     */
    public function orderBy(array $orderBy)
    {
        $this->queryContext->orderBy($orderBy);

        return $this;
    }

    /**
     * @param array $having
     * @return DriverInterface
     */
    public function having(array $having)
    {
        $this->queryContext->having($having);

        return $this;
    }

    /**
     * @param array $like
     * @return DriverInterface
     */
    public function like(array $like)
    {
        $this->queryContext->like($like);

        return $this;
    }

    /**
     * @param array $between
     * @return DriverInterface
     */
    public function between(array $between)
    {
        $this->queryContext->between($between);

        return $this;
    }

    /**
     * @param $sql
     * @return DriverInterface
     */
    public function createQuery($sql)
    {
        $this->queryContext->custom($sql);

        return $this;
    }

    public function find()
    {

    }

    public function findAll()
    {

    }

    public function remove()
    {

    }

    public function save()
    {

    }
}