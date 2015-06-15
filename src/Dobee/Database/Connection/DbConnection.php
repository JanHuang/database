<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/6/15
 * Time: 下午2:46
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */


namespace Dobee\Database\Connection;

use Dobee\Database\Driver\DriverConfig;
use Dobee\Database\Driver\DriverInterface;
use Dobee\Database\Driver\PDODriver;
use Dobee\Database\Repository\Repository;

/**
 * Class DbConnection
 *
 * @package Dobee\Database\Connection
 */
class DbConnection implements ConnectionInterface
{
    /**
     * @var DriverInterface
     */
    protected $driver;

    /**
     * @var string
     */
    protected $connectionName;

    protected $repositories = [];

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->driver = $this->createConnectionDriverSocket($config, isset($config['options']) ? $config['options'] : []);
    }

    /**
     * Create new database driver connection socket pipe.
     *
     * @param array $config
     * @param array $options
     * @return DriverInterface
     */
    protected function createConnectionDriverSocket(array $config, array $options = [])
    {
        return new PDODriver(new DriverConfig($config, $options));
    }

    /**
     * @param string $connection
     * @return $this
     */
    public function setConnectionName($connection)
    {
        $this->connectionName = $connection;

        return $this;
    }

    /**
     * Return current database connection name.
     *
     * @return string
     */
    public function getConnectionName()
    {
        return $this->connectionName;
    }

    /**
     * Start database transaction.
     *
     * @return bool
     */
    public function startTransaction()
    {
        return $this->driver->beginTransaction();
    }

    /**
     * Commit database transaction.
     *
     * @return bool
     */
    public function commit()
    {
        return $this->driver->commit();
    }

    /**
     * Transaction error. Transaction rollback.
     *
     * @return bool
     */
    public function rollback()
    {
        return $this->driver->rollBack();
    }

    /**
     * @param        $table
     * @param array  $where
     * @param array $field
     * @return array
     */
    public function find($table, array $where = [], array $field = ['*'])
    {
        return $this->driver->bind('')->getQuery();
    }

    /**
     * @param        $table
     * @param array  $where
     * @param array  $field
     * @return array
     */
    public function findAll($table, array $where = [], array $field = ['*'])
    {
        // TODO: Implement findAll() method.
    }

    /**
     * @param $dql
     * @return $this
     */
    public function createQuery($dql)
    {
        $this->driver->bind($dql);

        return $this;
    }

    /**
     * @param        $name
     * @param string $value
     * @return $this
     */
    public function setParameters($name, $value = null)
    {
        $parameters = [];

        if (!is_array($name)) {
            $parameters[$name] = $value;
        }

        $this->driver->setParameters($parameters);

        return $this;
    }

    /**
     * @return $this
     */
    public function getQuery()
    {
        $this->driver->getQuery();

        return $this;
    }

    /**
     * @return array
     */
    public function getResult()
    {
        return $this->driver->getResult();
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

    /**
     * @return mixed
     */
    public function close()
    {
        // TODO: Implement close() method.
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

    protected function parserSql()
    {

    }
}