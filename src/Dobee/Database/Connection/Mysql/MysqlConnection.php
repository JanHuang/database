<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/2/8
 * Time: 上午12:03
 * Github: https://www.github.com/janhuang 
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 */

namespace Dobee\Database\Connection\Mysql;

use Dobee\Database\Connection\ConnectionInterface;

/**
 * Class MysqlConnection
 *
 * @package Dobee\Kernel\Configuration\Drivers\Db\Mysql
 */
class MysqlConnection implements ConnectionInterface
{
    /**
     * @var \PDO
     */
    protected $driver;

    /**
     * @var \PDOStatement
     */
    protected $statement;

    /**
     * @param string $dsn
     * @param string $user
     * @param string $password
     * @param string $charset
     * @param array  $options
     */
    public function __construct($dsn, $user, $password, $charset = 'utf8', array $options = [])
    {
        $this->driver = new \PDO($dsn, $user, $password, [
                \PDO::MYSQL_ATTR_INIT_COMMAND => 'set names ' . $charset
        ]);
    }

    /**
     * Start database transaction.
     *
     * @return bool
     */
    public function beginTransaction()
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
     * @param        $name
     * @param string $value
     * @return $this
     */
    public function setParameters($name, $value = null)
    {
        $this->statement->bindParam(':' . $name, $value);

        return $this;
    }

    /**
     * @param $sql
     * @return $this
     */
    public function prepare($sql)
    {
        $this->statement = $this->driver->prepare($sql);

        return $this;
    }

    /**
     * @return $this
     */
    public function getQuery()
    {
        $this->statement->execute();

        return $this;
    }

    /**
     * @param null $name
     * @return array
     */
    public function getAll($name = null)
    {
        $result = $this->statement->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    /**
     * @param null $name
     * @return mixed
     */
    public function getOne($name = null)
    {
        $result = $this->statement->fetch(\PDO::FETCH_ASSOC);

        return null === $name ? $result : $result[$name];
    }

    /**
     * Get connection operation error information.
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->statement->errorInfo();
    }

    /**
     * @return array
     */
    public function getSql()
    {
        if (null === $this->statement) {
            return false;
        }

        return $this->statement->queryString;
    }

    /**
     * @return array
     */
    public function getLogs()
    {
    }

    /**
     * @return void
     */
    public function close()
    {
        $this->driver = null;
        $this->statement = null;
    }

    /**
     * Get connection detail information.
     *
     * @return string
     */
    public function getConnectionInfo()
    {
        $attributes = '';

        foreach ([
                    'driver'            => 'DRIVER_NAME',
                    'client version'    => 'CLIENT_VERSION',
                    'connection status' => 'CONNECTION_STATUS',
                    'server info'       => 'SERVER_INFO',
                    'server version'    => 'SERVER_VERSION',
                    'timeout'           => 'TIMEOUT',
                 ] as $name => $value) {
            $attributes .= $name . ': ' . $this->driver->getAttribute(constant('PDO::ATTR_' . $value)) . PHP_EOL;
        }

        return $attributes;
    }

    /**
     * @return int|false
     */
    public function getAffectedRow()
    {
        $row = $this->statement->rowCount();

        return $row;
    }

    /**
     * @return int|false
     */
    public function getLastId()
    {
        return $this->driver->lastInsertId();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getConnectionInfo();
    }
}