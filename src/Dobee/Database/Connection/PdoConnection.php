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

use Dobee\Database\Config;

/**
 * Class DbConnection
 *
 * @package Dobee\Database\Connection
 */
class PdoConnection implements ConnectionInterface
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
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->driver = new \PDO($config->getDsn(), $config->getDatabaseUser(), $config->getDatabasePwd(), $config->getOptions());
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
     * @return $this
     */
    public function getQuery()
    {
        $this->statement->execute();

        return $this;
    }

    /**
     * @return array
     */
    public function getResult()
    {
        $result = $this->statement->fetchAll(\PDO::FETCH_ASSOC);

        $this->statement = null;

        return $result;
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
     * @return array
     */
    public function info()
    {
        $info = [];

        foreach ([
                     \PDO::ATTR_AUTOCOMMIT,
                     \PDO::ATTR_CASE,
                     \PDO::ATTR_CLIENT_VERSION,
                     \PDO::ATTR_CONNECTION_STATUS,
                     \PDO::ATTR_CONNECTION_STATUS,
                 ] as $value) {
            $info[] = $this->driver->getAttribute($value);
        }

        return $info;
    }

    /**
     * @return array
     */
    public function error()
    {
        return null === $this->statement ? $this->driver->errorInfo() : $this->statement->errorInfo();
    }

    /**
     * @return void
     */
    public function close()
    {
        $this->driver = null;
    }
}