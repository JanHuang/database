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

/**
 * Class PDODriver
 *
 * @package Dobee\Database\Driver
 */
class PDODriver implements DriverInterface
{
    /**
     * @var \PDO
     */
    protected $driver;

    /**
     * @var DriverConfig
     */
    protected $config;

    /**
     * @var \PDOStatement
     */
    protected $statement;

    /**
     * @param DriverConfig $config
     */
    public function __construct(DriverConfig $config)
    {
        $this->driver = new \PDO($config->getDsn(), $config->getDatabaseUser(), $config->getDatabasePwd(), $config->getOptions());

        $this->config = $config;
    }

    /**
     * @return bool
     */
    public function beginTransaction()
    {
        return $this->driver->beginTransaction();
    }

    /**
     * @return bool
     */
    public function commit()
    {
        return $this->driver->commit();
    }

    /**
     * @return bool
     */
    public function rollback()
    {
        return $this->driver->rollBack();
    }

    /**
     * @return array
     */
    public function error()
    {
        return $this->driver->errorInfo();
    }

    /**
     * @return bool
     */
    public function logs()
    {
        return $this->statement->debugDumpParams();
    }

    /**
     * @param $sql
     * @return $this
     */
    public function bind($sql)
    {
        $this->statement = $this->driver->prepare($sql);

        return $this;
    }

    /**
     * @param array $parameters
     * @return $this
     */
    public function setParameters(array $parameters)
    {
        foreach ($parameters as $name => $value) {
            $this->statement->bindParam(':' . $name, $value, \PDO::PARAM_STR);
        }

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
        return $this->statement->fetchAll(\PDO::FETCH_ASSOC);
    }
}