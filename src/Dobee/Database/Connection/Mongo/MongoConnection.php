<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/4/27
 * Time: 下午5:47
 * Github: https://www.github.com/janhuang 
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 */

namespace Dobee\Database\Connection\Mongo;

use Dobee\Database\Connection\ConnectionInterface;
use Dobee\Database\Repository\Repository;

class MongoConnection implements ConnectionInterface
{

    /**
     * @param string $connection
     * @return $this
     */
    public function setConnectionName($connection)
    {
        // TODO: Implement setConnectionName() method.
    }

    /**
     * @return string
     */
    public function getConnectionName()
    {
        // TODO: Implement getConnectionName() method.
    }

    /**
     * @param        $table
     * @param array  $where
     * @param string $field
     * @return \Dobee\Database\QueryResult\Result
     */
    public function find($table, $where, $field = '*')
    {
        // TODO: Implement find() method.
    }

    /**
     * @param        $table
     * @param array  $where
     * @param string $field
     * @return \Dobee\Database\QueryResult\ResultCollection
     */
    public function findAll($table, $where = array(), $field = '*')
    {
        // TODO: Implement findAll() method.
    }

    /**
     * @param $dql
     * @return $this
     */
    public function createQuery($dql)
    {
        // TODO: Implement createQuery() method.
    }

    /**
     * @param        $name
     * @param string $value
     * @return $this
     */
    public function setParameters($name, $value = '')
    {
        // TODO: Implement setParameters() method.
    }

    /**
     * @return mixed
     */
    public function getQuery()
    {
        // TODO: Implement getQuery() method.
    }

    /**
     * @return \Dobee\Database\QueryResult\ResultCollection
     */
    public function getResult()
    {
        // TODO: Implement getResult() method.
    }

    /**
     * @param $repository
     * @return Repository
     */
    public function getRepository($repository)
    {
        // TODO: Implement getRepository() method.
    }

    /**
     * @param       $table
     * @param array $data
     * @return int|bool
     */
    public function insert($table, $data = array())
    {
        // TODO: Implement insert() method.
    }

    /**
     * @param       $table
     * @param array $data
     * @param array $where
     * @return int|bool
     */
    public function update($table, $data = array(), $where = array())
    {
        // TODO: Implement update() method.
    }

    /**
     * @param       $table
     * @param array $where
     * @return int|bool
     */
    public function delete($table, $where = array())
    {
        // TODO: Implement delete() method.
    }

    /**
     * @param       $table
     * @param array $where
     * @return int|bool
     */
    public function count($table, $where = array())
    {
        // TODO: Implement count() method.
    }

    /**
     * @param       $table
     * @param array $where
     * @return int|bool
     */
    public function has($table, $where = array())
    {
        // TODO: Implement has() method.
    }

    /**
     * @return array|bool
     */
    public function logs()
    {
        // TODO: Implement logs() method.
    }

    /**
     * @return array
     */
    public function error()
    {
        // TODO: Implement error() method.
    }

    /**
     * @return string
     */
    public function getLastQuery()
    {
        // TODO: Implement getLastQuery() method.
    }
}