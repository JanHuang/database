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

use FastD\Database\Drivers\Query\MySQLQueryBuilder;
use FastD\Database\Drivers\Query\QueryBuilderInterface;

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
     * @var MySQLQueryBuilder
     */
    protected $queryBuilder;

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
     * @return QueryBuilderInterface
     */
    public function getQueryBuilder()
    {
        return $this->queryBuilder;
    }

    /**
     * @param QueryBuilderInterface $queryBuilderInterface
     * @return $this
     */
    public function setQueryBuilder(QueryBuilderInterface $queryBuilderInterface)
    {
        $this->queryBuilder = $queryBuilderInterface;

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
        $this->queryBuilder->where($where);

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
        $this->queryBuilder->fields($field);

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
        $this->queryBuilder->join($table, $on, $type);

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
        $this->queryBuilder->table($table);

        return $this;
    }

    /**
     * @param $offset
     * @param $limit
     * @return DriverInterface
     */
    public function limit($offset, $limit)
    {
        $this->queryBuilder->limit($offset, $limit);

        return $this;
    }

    /**
     * @param array $groupBy
     * @return DriverInterface
     */
    public function groupBy(array $groupBy)
    {
        $this->queryBuilder->groupBy($groupBy);

        return $this;
    }

    /**
     * @param array $orderBy
     * @return DriverInterface
     */
    public function orderBy(array $orderBy)
    {
        $this->queryBuilder->orderBy($orderBy);

        return $this;
    }

    /**
     * @param array $having
     * @return DriverInterface
     */
    public function having(array $having)
    {
        $this->queryBuilder->having($having);

        return $this;
    }

    /**
     * @param array $like
     * @return DriverInterface
     */
    public function like(array $like)
    {
        $this->queryBuilder->like($like);

        return $this;
    }

    /**
     * @param array $between
     * @return DriverInterface
     */
    public function between(array $between)
    {
        $this->queryBuilder->between($between);

        return $this;
    }

    /**
     * @param $sql
     * @return DriverInterface
     */
    public function createQuery($sql)
    {
        $this->queryBuilder->custom($sql);

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