<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/3/12
 * Time: 上午11:15
 * Github: https://www.github.com/janhuang 
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 */

namespace Dobee\Database\Repository;

use Dobee\Database\Connection\ConnectionInterface;

/**
 * Class Repository
 *
 * @package Dobee\Database\Repository
 */
class Repository
{
    /**
     * @var string
     */
    protected $table;

    /**
     * @return string
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @param string $table
     * @return $this
     */
    public function setTable($table)
    {
        $this->table = $table;

        return $this;
    }

    /**
     * @return string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * @param string $prefix
     * @return $this
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * @var string
     */
    protected $prefix;

    /**
     * @return ConnectionInterface
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @param ConnectionInterface $connection
     * @return $this
     */
    public function setConnection($connection)
    {
        $this->connection = $connection;

        return $this;
    }
    /**
     * @var ConnectionInterface
     */
    protected $connection;

    /**
     * @param array $where
     * @param array|string $field
     * @return array
     */
    public function find($where = array(), $field = '*')
    {
        if (!is_array($where)) {
            $where = array('id' => $where);
        }

        return $this->connection->find($this->getTable(), $where, $field);
    }

    /**
     * @param array $where
     * @param array|string $field
     * @return array
     */
    public function findAll($where = array(),  $field = '*')
    {
        if (!is_array($where)) {
            $where = array('id' => $where);
        }

        return $this->connection->findAll($this->getTable(), $where, $field);
    }

    /**
     * @param $method
     * @param $arguments
     * @return array
     */
    public function __call($method, $arguments)
    {
        if ('find' == substr($method, 0, 4)) {
            switch (strtolower(substr($method, 4, 3))) {
                case 'all':
                    $field = str_replace('findAllBy', '', $method);
                    $method = 'findAll';
                    break;
                default:
                    $field = str_replace('findBy', '', $method);
                    $method = 'find';
            }

            $field = preg_replace_callback(
                '([A-Z])',
                function ($matches) {
                    return '_' . strtolower($matches[0]);
                },
                $field
            );

            $arguments = array(
                ltrim($field, '_') => $arguments[0]
            );

            return call_user_func_array(array($this, $method), $arguments);
        }

        return call_user_func_array(array($this->connection, $method), $arguments);
    }

    /**
     * @return array|bool
     */
    public function logs()
    {
        return $this->connection->logs();
    }

    /**
     * @param array $data
     * @return int|bool
     */
    public function insert(array $data = array())
    {
        return $this->connection->insert($this->table, $data);
    }

    /**
     * @param array $data
     * @param array $where
     * @return int|bool
     */
    public function update(array $data = array(), $where = array())
    {
        return $this->connection->update($this->table, $data, $where);
    }

    /**
     * @param array $where
     * @return int|bool
     */
    public function delete(array $where = array())
    {
        if (empty($where)) {
            return false;
        }

        return $this->connection->delete($this->table, $where);
    }

    /**
     * @param array $where
     * @return int|bool
     */
    public function count(array $where = array())
    {
        return $this->connection->count($this->table, $where);
    }

    /**
     * @param array $where
     * @return int|bool
     */
    public function has(array $where = array())
    {
        return $this->connection->has($this->table, $where);
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->connection->error();
    }

    /**
     * @return string
     */
    public function getLastQuery()
    {
        return $this->connection->getLastQuery();
    }
}