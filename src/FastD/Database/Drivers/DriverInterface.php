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
     * @param $sql
     * @return DriverInterface
     */
    public function createQuery($sql);

    /**
     * Bind pdo parameters.
     *
     * @param $name
     * @param $value
     * @return $this
     */
    public function setParameter($name, $value);

    /**
     * Create PDO
     *
     * @return $this
     */
//    public function getQuery();

    /**
     * @param array $params
     * @return array|bool
     */
    public function find(array $params = null);

    /**
     * @param array $params
     * @return array|bool
     */
    public function findAll(array $params = null);

    /**
     * @param array $data
     * @param int|null $id
     * @return int|bool
     */
    public function save(array $data, $id = null);

    /**
     * Get table repository object.
     *
     * @param string $repository
     * @return Repository
     */
    public function getRepository($repository);
}