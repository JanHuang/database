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

namespace Dobee\Database\Connection;

use Dobee\Database\Repository\Repository;

/**
 * Interface ConnectionInterface
 *
 * @package Dobee\Database\Connection
 */
interface ConnectionInterface
{
    /**
     * Constructor.
     * Sub database module config.
     *
     * @param array $config
     */
    public function __construct(array $config);

    /**
     * @param string $connection
     * @return $this
     */
    public function setConnectionName($connection);

    /**
     * Return current database connection name.
     *
     * @return string
     */
    public function getConnectionName();

    /**
     * Start database transaction.
     *
     * @return bool
     */
    public function startTransaction();

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
     * @param        $table
     * @param array  $where
     * @param array $field
     * @return array
     */
    public function find($table, array $where, array $field = ['*']);

    /**
     * @param        $table
     * @param array  $where
     * @param array $field
     * @return array
     */
    public function findAll($table, array $where, array $field = ['*']);

    /**
     * @param $dql
     * @return $this
     */
    public function createQuery($dql);

    /**
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
     * @return array
     */
    public function getResult();

    /**
     * @param $repository
     * @return Repository
     */
    public function getRepository($repository);

    /**
     * @param       $table
     * @param array $data
     * @return int|bool
     */
    public function insert($table, array $data = array());

    /**
     * @param       $table
     * @param array $data
     * @param array $where
     * @return int|bool
     */
    public function update($table, array $data = array(), array $where = array());

    /**
     * @param       $table
     * @param array $where
     * @return int|bool
     */
    public function delete($table, array $where = array());

    /**
     * @param       $table
     * @param array $where
     * @return int|bool
     */
    public function count($table, array $where = array());

    /**
     * @param       $table
     * @param array $where
     * @return int|bool
     */
    public function has($table, array $where = array());

    /**
     * @param       $table
     * @param array $data
     * @param array $where
     * @return int|bool
     */
    public function replace($table, array $data, array $where);

    /**
     * @return array|bool
     */
    public function logs();

    /**
     * @return array
     */
    public function error();

    /**
     * @return string
     */
    public function getLastQuery();

    /**
     * @return mixed
     */
    public function close();
}