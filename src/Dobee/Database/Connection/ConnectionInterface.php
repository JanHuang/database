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
     * @param string $connection
     * @return $this
     */
    public function setConnectionName($connection);

    /**
     * @return string
     */
    public function getConnectionName();

    /**
     * @param        $table
     * @param array  $where
     * @param string $field
     * @return \Dobee\Database\QueryResult\Result
     */
    public function find($table, $where, $field = '*');

    /**
     * @param        $table
     * @param array  $where
     * @param string $field
     * @return \Dobee\Database\QueryResult\ResultCollection
     */
    public function findAll($table, $where = array(), $field = '*');

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
     * @return mixed
     */
    public function getQuery();

    /**
     * @return \Dobee\Database\QueryResult\ResultCollection
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
    public function insert($table, $data = array());

    /**
     * @param       $table
     * @param array $data
     * @param array $where
     * @return int|bool
     */
    public function update($table, $data = array(), $where = array());

    /**
     * @param       $table
     * @param array $where
     * @return int|bool
     */
    public function delete($table, $where = array());

    /**
     * @param       $table
     * @param array $where
     * @return int|bool
     */
    public function count($table, $where = array());

    /**
     * @param       $table
     * @param array $where
     * @return int|bool
     */
    public function has($table, $where = array());

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
}