<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/12/13
 * Time: 下午8:20
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Database\Drivers;

use FastD\Database\Drivers\Connection\ConnectionInterface;
use FastD\Database\QueryContext\QueryContextInterface;

/**
 * Class DriverAbstract
 *
 * @package FastD\Database\Drivers
 */
abstract class DriverAbstract implements DriverInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var ConnectionInterface
     */
    protected $connection;

    /**
     * @var QueryContextInterface
     */
    protected $context;

    /**
     * @return QueryContextInterface
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * @param QueryContextInterface $context
     * @return $this
     */
    public function setContext(QueryContextInterface $context)
    {
        $this->context = $context;

        return $this;
    }

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
    public function setConnection(ConnectionInterface $connection)
    {
        $this->connection = $connection;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
}