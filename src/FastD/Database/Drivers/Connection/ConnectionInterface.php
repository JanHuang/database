<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/2/8
 * Time: 上午12:02
 * Github: https://www.github.com/janhuang 
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 */

namespace FastD\Database\Drivers\Connection;

/**
 * Interface ConnectionInterface
 *
 * @package FastD\Database\Connection
 */
interface ConnectionInterface
{
    /**
     * @return \PDOStatement
     */
    public function getStatement();

    /**
     * @param \PDOStatement $statement
     * @return $this
     */
    public function setStatement(\PDOStatement $statement);

    /**
     * @return \PDO
     */
    public function getPDO();

    /**
     * @param \PDO $PDO
     * @return $this
     */
    public function setPDO(\PDO $PDO);

    /**
     * Begin server transaction.
     *
     * @param \Closure $closure
     * @return mixed
     */
    public function transaction(\Closure $closure);

    /**
     * Start database transaction.
     *
     * @return bool
     */
    public function begin();

    /**
     * Commit database transaction.
     *
     * @return bool
     */
    public function commit();

    /**
     * Transaction error. Transaction rollback.
     *
     * @return bool
     */
    public function rollback();

    /**
     * @param $dql
     * @return $this
     */
    public function prepare($dql);

    /**
     * Bind prepare value. But the name is no has ':'.
     *
     * @param        $name
     * @param string $value
     * @return $this
     */
    public function setParameters($name, $value = '');

    /**
     * @return $this
     */
    public function getQuery();

    /**
     * @return array|bool
     */
    public function getColumn();

    /**
     * @return int|bool
     */
    public function getCount();

    /**
     * @return array|bool
     */
    public function getAll();

    /**
     * @param string $name
     * @return array|bool
     */
    public function getOne($name = null);

    /**
     * @return int|false
     */
    public function getAffectedRow();

    /**
     * @return int|false
     */
    public function getLastId();

    /**
     * Get connection detail information.
     *
     * @return array|bool
     */
    public function getConnectionInfo();

    /**
     * Get connection operation error information.
     *
     * @return array
     */
    public function getErrors();

    /**
     * @return void
     */
    public function close();
}