<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/6/15
 * Time: 下午9:44
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace Dobee\Database\Driver;

use Dobee\Database\Config;
use Dobee\Database\Connection\Mysql\MysqlConnection;
use Dobee\Database\Query\QueryContext;

/**
 * Class PDODriver
 *
 * @package Dobee\Database\Driver
 */
class MysqlDriver extends DbDriverAbstract
{
    /**
     * @var MysqlConnection
     */
    protected $connection;

    /**
     * @var \PDOStatement
     */
    protected $statement;

    /**
     * @var QueryContext
     */
    protected $queryContext;

    /**
     * @param $config
     */
    public function __construct(Config $config)
    {
        $this->connection = new MysqlConnection($config);

        $this->queryContext = new QueryContext();
    }

    /**
     * @return string
     */
    public function getSql()
    {
        return null === $this->queryContext ? null : $this->queryContext->getSql();
    }

    /**
     * @return string
     *
     * @api
     */
    public function log()
    {
        return null === $this->queryContext ? null : $this->queryContext->getSql();
    }

    /**
     * @return array
     */
    public function error()
    {
        return $this->connection->error();
    }

    public function info()
    {
        return $this->connection->info();
    }

    /**
     * @return bool
     */
    public function beginTransaction()
    {
        return $this->connection->beginTransaction();
    }

    /**
     * @return bool
     */
    public function commit()
    {
        return $this->connection->commit();
    }

    /**
     * @return bool
     */
    public function rollback()
    {
        return $this->connection->rollBack();
    }

    /**
     * @param $sql
     * @return $this
     */
    public function createQuery($sql)
    {
        $this->connection->prepare($sql);

        return $this;
    }

    /**
     * @param mixed $name
     * @param null  $value
     * @return $this
     */
    public function setParameters($name, $value = null)
    {
        if (!is_array($name)) {
            $this->connection->setParameters($name, $value);
            return $this;
        }

        foreach ($name as $key => $value) {
            $this->connection->setParameters($name, $value);
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function getQuery()
    {
        $this->connection->getQuery();

        return $this;
    }

    /**
     * @return array
     */
    public function getResult()
    {
        return $this->connection->getResult();
    }

    public function fields(array $fields = [])
    {
        $this->queryContext->fields($fields);

        return $this;
    }

    public function group($group)
    {
        $this->queryContext->group($group);

        return $this;
    }

    public function having(array $having)
    {
        $this->queryContext->having($having);
    }

    public function order($order)
    {
        $this->queryContext->order($order);

        return $this;
    }

    public function limit($limit, $offset = null)
    {
        $this->queryContext->limit($limit, $offset);

        return $this;
    }

    public function where(array $where = [])
    {
        $this->queryContext->where($where);

        return $this;
    }

    public function find($table, array $where = [], array $fields = [])
    {
        $sql = $this->queryContext
            ->table($table)
            ->fields($fields)
            ->where($where)
            ->limit(1)
            ->select()
            ->getSql()
        ;

        $result = $this->connection->prepare($sql)->getQuery()->getResult();

        return isset($result[0]) ? $result[0] : [];
    }

    public function findAll($table, array $where = [], array $fields = [])
    {
        $sql = $this->queryContext
            ->table($table)
            ->fields($fields)
            ->where($where)
            ->select()
            ->getSql()
        ;

        return $this->connection->prepare($sql)->getQuery()->getResult();
    }

    /**
     * @param       $table
     * @param array $data
     * @return int|bool
     */
    public function insert($table, array $data = array())
    {
        $sql = $this->queryContext
            ->table($table)
            ->data($data, 'INSERT')
            ->insert()
            ->getSql()
        ;

        return $this->connection->prepare($sql)->getQuery()->getResult();
    }

    /**
     * @param       $table
     * @param array $data
     * @param array $where
     * @return int|bool
     */
    public function update($table, array $data = array(), array $where = array())
    {
        $sql = $this->queryContext
            ->table($table)
            ->data($data, 'UPDATE')
            ->where($where)
            ->update()
            ->getSql()
        ;

        return $this->connection->prepare($sql)->getQuery()->getResult();
    }

    /**
     * @param       $table
     * @param array $where
     * @return int|bool
     */
    public function delete($table, array $where = array())
    {
        $sql = $this->queryContext
            ->table($table)
            ->where($where)
            ->delete()
            ->getSql()
        ;

        return $this->connection->prepare($sql)->getQuery()->getResult();
    }

    /**
     * @param       $table
     * @param array $where
     * @return int|bool
     */
    public function count($table, array $where = array())
    {
        $sql = $this->queryContext
            ->table($table)
            ->where($where)
            ->fields(['COUNT(1) as total'])
            ->limit(1)
            ->select()
            ->getSql()
        ;

        $result = $this->connection->prepare($sql)->getQuery()->getResult();

        return isset($result[0]) ? $result[0]['total'] : false;
    }

    /**
     * @param       $table
     * @param array $where
     * @return int|bool
     */
    public function has($table, array $where = array())
    {
        return $this->count($table, $where) ? true : false;
    }
}