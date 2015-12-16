<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/12/13
 * Time: 上午11:09
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Database\Drivers;

use FastD\Database\ORM\Repository;
use FastD\Database\Drivers\Query\QueryBuilderInterface;

/**
 * Interface DriverInterface
 *
 * @package FastD\Database\Drivers
 */
interface DriverInterface
{
    /**
     * @param $name
     * @return DriverInterface
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getName();

    /**
     * @return \PDO
     */
    public function getPDO();

    /**
     * @param \PDO $PDO
     * @return DriverInterface
     */
    public function setPDO(\PDO $PDO);

    /**
     * @return \PDOStatement
     */
    public function getPDOStatement();

    /**
     * @param \PDOStatement $PDOStatement
     * @return $this
     */
    public function setPDOStatement(\PDOStatement $PDOStatement);

    /**
     * Query select where condition.
     *
     * @param array $where
     * @return DriverInterface
     */
    public function where(array $where);

    /**
     * Query fields.
     *
     * @param array $field
     * @return DriverInterface
     */
    public function field(array $field = ['*']);

    /**
     * Select join.
     *
     * @param        $table
     * @param        $on
     * @param string $type
     * @return DriverInterface
     */
    public function join($table, $on, $type = 'LEFT');

    /**
     * Select to table name.
     *
     * @param $table
     * @return DriverInterface
     */
    public function table($table);

    /**
     * @param $offset
     * @param $limit
     * @return DriverInterface
     */
    public function limit($offset, $limit);

    /**
     * @param array $groupBy
     * @return DriverInterface
     */
    public function groupBy(array $groupBy);

    /**
     * @param array $orderBy
     * @return DriverInterface
     */
    public function orderBy(array $orderBy);

    /**
     * @param array $having
     * @return DriverInterface
     */
    public function having(array $having);

    /**
     * @param array $like
     * @return DriverInterface
     */
    public function like(array $like);

    /**
     * Create SQL query statement.
     *
     * @param $sql
     * @return DriverInterface
     */
    public function createQuery($sql);

    /**
     * Execute create PDO query statement.
     *
     * @return $this
     */
    public function getQuery();

    /**
     * Bind pdo parameters.
     *
     * @param $name
     * @param $value
     * @return $this
     */
    public function setParameter($name, $value);

    /**
     * @return array|bool
     */
    public function getOne();

    /**
     * @return array|bool
     */
    public function getAll();

    /**
     * @return int|bool
     */
    public function getId();

    /**
     * @return int|bool
     */
    public function getAffected();

    /**
     * @param array $params
     * @return array|bool
     */
    public function find(array $params = []);

    /**
     * @param array $params
     * @return array|bool
     */
    public function findAll(array $params = []);

    /**
     * @param array $data
     * @param array $params
     * @param array $where
     * @return int|bool
     */
    public function save(array $data, array $where = [], array $params = []);

    /**
     * @param string $table
     * @param array $where
     * @param array $params
     * @return int
     */
    public function count(array $where = [], array $params = []);

    /**
     * Get table repository object.
     *
     * @param string $repository
     * @return Repository
     */
    public function getRepository($repository);

    /**
     * @return array
     */
    public function getErrors();

    /**
     * @return QueryBuilderInterface
     */
    public function getQueryBuilder();
}