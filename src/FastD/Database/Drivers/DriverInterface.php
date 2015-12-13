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

/**
 * Interface DriverInterface
 *
 * @package FastD\Database\Drivers
 */
interface DriverInterface
{
    /**
     * @param $name
     * @return $this
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param \PDO $PDO
     * @return mixed
     */
    public function setPDO(\PDO $PDO);

    /**
     * @return \PDO
     */
    public function getPDO();

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
     * @param array $between
     * @return DriverInterface
     */
    public function between(array $between);

    /**
     * @param $sql
     * @return DriverInterface
     */
    public function createQuery($sql);
}