<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/6/18
 * Time: 下午7:58
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Database\Driver;

use FastD\Database\Config;
use FastD\Database\Connection\ConnectionInterface;
use FastD\Database\Connection\Mysql\MysqlConnection;
use FastD\Database\Pagination\QueryPagination;
use FastD\Database\Query\QueryContext;
use FastD\Database\Repository\Repository;

/**
 * Class Driver
 *
 * @package FastD\Database\Driver
 */
class Driver
{
    /**
     * @var ConnectionInterface
     */
    protected $connection;

    /**
     * @var QueryContext
     */
    protected $queryContext;

    /**
     * @var array
     */
    protected $repositories = [];

    /**
     * @var Config
     */
    protected $config;

    /**
     * Constructor.
     * Create different database connection.
     *
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        switch ($config->getDatabaseType()) {
            case 'mysql':
            case 'maraidb':
            default:
                $this->connection = new MysqlConnection($config->getDsn(), $config->getDatabaseUser(), $config->getDatabasePwd(), $config->getDatabaseCharset(), $config->getOptions());
                $this->queryContext = new QueryContext();
        }

        $this->config = $config;
    }

    /**
     * @return ConnectionInterface|MysqlConnection
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @return QueryContext
     */
    public function getQueryContext()
    {
        return $this->queryContext;
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
     * @param       $table
     * @param array $where
     * @param array $fields
     * @return array|bool|mixed
     */
    public function find($table, array $where = [], array $fields = [])
    {
        $sql = $this->queryContext->table($table)->where($where)->limit(1)->fields($fields)->select()->getSql();

        return $this->connection->prepare($sql)->getQuery()->getOne();
    }

    /**
     * @param       $table
     * @param array $where
     * @param array $fields
     * @return array|bool
     */
    public function findAll($table, array $where = [], array $fields = [])
    {
        $sql = $this->queryContext->table($table)->where($where)->fields($fields)->select()->getSql();

        return $this->connection->prepare($sql)->getQuery()->getAll();
    }

    /**
     * @param       $table
     * @param int   $page
     * @param int   $showList
     * @param int   $showPage
     * @param int   $lastId
     * @return QueryPagination
     */
    public function pagination($table, $page = 1, $showList = 25, $showPage = 5, $lastId = null)
    {
        return new QueryPagination($this->table($table), $page, $showList, $showPage, $lastId);
    }

    /**
     * @param       $table
     * @param array $data
     * @param array $where
     * @return false|int
     */
    public function update($table, array $data, array $where = [])
    {
        $sql = $this->queryContext->table($table)->data($data, QueryContext::CONTEXT_UPDATE)->where($where)->update()->getSql();

        return $this->connection->prepare($sql)->getQuery()->getAffectedRow();
    }

    /**
     * @param       $table
     * @param array $data
     * @return false|int
     */
    public function insert($table, array $data)
    {
        $sql = $this->queryContext->table($table)->data($data, QueryContext::CONTEXT_INSERT)->insert()->getSql();

        return $this->connection->prepare($sql)->getQuery()->getLastId();
    }

    /**
     * @param       $table
     * @param array $where
     * @return array|bool|mixed
     */
    public function count($table, array $where = [])
    {
        $sql = $this->queryContext->table($table)->limit(1)->fields(['COUNT(1) as total'])->where($where)->select()->getSql();

        return $this->connection->prepare($sql)->getQuery()->getOne('total');
    }

    /**
     * @return array|string
     */
    public function getQueryString()
    {
        return $this->getSql();
    }

    /**
     * @param $sql
     * @return Driver
     */
    public function createQuery($sql)
    {
        $this->connection->prepare($sql);

        return $this;
    }

    /**
     * @param $name
     * @param $value
     * @return $this
     */
    public function setParameters($name, $value)
    {
        $this->connection->setParameters($name, $value);

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
     * @return array|bool
     */
    public function getAll()
    {
        return $this->connection->getAll();
    }

    /**
     * @param null $name
     * @return array|bool|mixed
     */
    public function getOne($name = null)
    {
        return $this->connection->getOne($name);
    }

    /**
     * @return false|int
     */
    public function getAffectedRow()
    {
        return $this->connection->getAffectedRow();
    }

    /**
     * @return false|int
     */
    public function getLastId()
    {
        return $this->connection->getLastId();
    }

    /**
     * @param $table
     * @return $this
     */
    public function table($table)
    {
        $this->queryContext->table($table);

        return $this;
    }

    /**
     * @param array $fields
     * @return $this
     */
    public function fields(array $fields = [])
    {
        $this->queryContext->fields($fields);

        return $this;
    }

    /**
     * @param $group
     * @return $this
     */
    public function group($group)
    {
        $this->queryContext->group($group);

        return $this;
    }

    /**
     * @param array $having
     */
    public function having(array $having)
    {
        $this->queryContext->having($having);
    }

    /**
     * @param $order
     * @return $this
     */
    public function order($order)
    {
        $this->queryContext->order($order);

        return $this;
    }

    /**
     * @param      $limit
     * @param null $offset
     * @return $this
     */
    public function limit($limit, $offset = null)
    {
        $this->queryContext->limit($limit, $offset);

        return $this;
    }

    /**
     * @param array $where
     * @return $this
     */
    public function where(array $where = [])
    {
        $this->queryContext->where($where);

        return $this;
    }

    /**
     * @return array|string
     */
    public function getSql()
    {
        return (false === ($sql = $this->connection->getSql())) ? $this->queryContext->getSql() : $sql;
    }

    /**
     * @return string
     */
    public function getConnectionInfo()
    {
        return $this->connection->getConnectionInfo();
    }

    /**
     * @param $name
     * @return Repository
     */
    public function getRepository($name)
    {
        $name = str_replace(':', '\\', $name);

        if (isset($this->repositories[$name])) {
            return $this->repositories[$name];
        }

        $repository = new $name($this);

        if (null === $repository->getTable()) {
            $repositoryArray = explode('\\', $name);
            $defaultName = end($repositoryArray); unset($repositoryArray);
            $defaultName = strtolower(trim(preg_replace('/([A-Z])/', '_$1', $defaultName), '_'));
            $repository->setTable($this->config->getDatabasePrefix() . $defaultName . $this->config->getDatabaseSuffix());
        }

        $this->repositories[$name] = $repository;

        return $this->repositories[$name];
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->connection->getErrors();
    }

    /**
     * @return array
     */
    public function getLogs()
    {
        return $this->connection->getLogs();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getConnectionInfo();
    }
}