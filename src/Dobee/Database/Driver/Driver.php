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

namespace Dobee\Database\Driver;

use Dobee\Database\Config;
use Dobee\Database\Connection\ConnectionInterface;
use Dobee\Database\Connection\Mysql\MysqlConnection;
use Dobee\Database\Query\QueryContext;

/**
 * Class Driver
 *
 * @package Dobee\Database\Driver
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
                $this->setConnection(new MysqlConnection($config->getDsn(), $config->getDatabaseUser(), $config->getDatabasePwd(), $config->getDatabaseCharset(), $config->getOptions()));
                $this->queryContext = new QueryContext();
        }
    }

    public function setConnection(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    public function getConnection()
    {
        return $this->connection;
    }

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

    public function find($table, array $where = [], array $fields = [])
    {

    }

    public function findAll($table, array $where = [], array $fields = [])
    {

    }

    public function findPage()
    {

    }

    public function update($table, array $data, array $where = [])
    {
        $sql = $this->queryContext->table($table)->data($data, QueryContext::CONTEXT_UPDATE)->where($where)->update()->getSql();

        return $this->connection->prepare($sql)->getQuery()->getAffectedRow();
    }

    public function insert($table, array $data)
    {
        $sql = $this->queryContext->table($table)->data($data, QueryContext::CONTEXT_INSERT)->insert()->getSql();

        return $this->connection->prepare($sql)->getQuery()->getLastId();
    }

    public function count($table, array $where)
    {}

    public function has($table, array $where = [])
    {}

    public function getQueryString()
    {
        return $this->connection->getSql();
    }

    public function createQuery($sql)
    {
        $this->connection->prepare($sql);

        return $this;
    }

    public function getQuery()
    {
        $this->connection->getQuery();

        return $this;
    }

    public function getResult()
    {
        return $this->connection->getAll();
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

    public function getSql()
    {
        return (false === ($sql = $this->connection->getSql())) ? $this->queryContext->getSql() : $sql;
    }
}