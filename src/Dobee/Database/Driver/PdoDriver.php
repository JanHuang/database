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
abstract class PdoDriver implements DriverInterface
{
    /**
     * @var MysqlConnection
     */
    protected $connection;

    /**
     * @var \PDOStatement
     */
    protected $statement;

    protected $queryContext;

    /**
     * @param $config
     */
    public function __construct(Config $config)
    {
        $this->connection = new MysqlConnection($config);
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
     * @return array
     */
    public function error()
    {
        return $this->connection->error();
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

    /**
     * @return string
     */
    public function getSql()
    {
        // TODO: Implement getSql() method.
    }

    /**
     * @return string
     *
     * @api
     */
    public function log()
    {
    }

    public function find($table, array $where = [], array $fields = ['*'])
    {
        $context = $this->createQueryContext($table, $where, $fields);

        $sql = $context->limit(1)->select()->getSql();

        $result = $this->connection->prepare($sql)->getQuery()->getResult();

        return isset($result[0]) ? $result[0] : [];
    }

    public function findAll($table, array $where = [], array $fields = ['*'])
    {
        // TODO: Implement findAll() method.
    }

    /**
     * @param $repository
     * @return Repository
     */
    public function getRepository($repository)
    {
        if (isset($this->repositories[$repository])) {
            return $this->repositories[$repository];
        }

        if (false !== strpos($repository, ':')) {
            $repository = str_replace(':', '\\', $repository);
        }
        $name = $repository;
        $repository .= 'Repository';
        $repository = new $repository();
        if ($repository instanceof Repository) {
            $repository
                ->setConnection($this)
                ->setPrefix($this->getPrefix())
            ;
            if (null === $repository->getTable()) {
                $repository->setTable($this->parseTableName($name));
            }
        }
        return $repository;
    }

    /**
     * @param       $table
     * @param array $data
     * @return int|bool
     */
    public function insert($table, array $data = array())
    {
        // TODO: Implement insert() method.
    }

    /**
     * @param       $table
     * @param array $data
     * @param array $where
     * @return int|bool
     */
    public function update($table, array $data = array(), array $where = array())
    {
        // TODO: Implement update() method.
    }

    /**
     * @param       $table
     * @param array $where
     * @return int|bool
     */
    public function delete($table, array $where = array())
    {
        // TODO: Implement delete() method.
    }

    /**
     * @param       $table
     * @param array $where
     * @return int|bool
     */
    public function count($table, array $where = array())
    {
        // TODO: Implement count() method.
    }

    /**
     * @param       $table
     * @param array $where
     * @return int|bool
     */
    public function has($table, array $where = array())
    {
        // TODO: Implement has() method.
    }

    /**
     * @param       $table
     * @param array $data
     * @param array $where
     * @return int|bool
     */
    public function replace($table, array $data, array $where)
    {
        // TODO: Implement replace() method.
    }

    public function info()
    {
        return $this->connection->info();
    }

    /**
     * @param       $table
     * @param array $where
     * @param array $fields
     * @return QueryContext
     */
    public function createQueryContext($table, array $where, array $fields = ['*'])
    {
        if (null === $this->queryContext) {
            $this->queryContext = new QueryContext($table, $where, $fields);
        } else {
            $this->queryContext = clone $this->queryContext;
        }

        return $this->queryContext;
    }
}