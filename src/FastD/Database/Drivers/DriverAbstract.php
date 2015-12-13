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

use FastD\Database\Drivers\Connection\Connection;
use FastD\Database\Drivers\QueryContext\MySQLQueryContext;
use FastD\Database\Drivers\QueryContext\QueryContextInterface;
use FastD\Database\Drivers\Connection\ConnectionInterface;

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

    public function __construct(array $config)
    {
        switch ($config['database_type']) {
            case 'pgsql':
                $queryContext = null;
                $dsn = 'pgsql:host=' . $config['database_host'] . ';port=' . $config['database_port'] . ';dbname=' . $config['database_name'];
                break;
            case 'sybase':
                $queryContext = null;
                $dsn = 'dblib:host=' . $config['database_host'] . ';port=' . $config['database_port'] . ';dbname=' . $config['database_name'];
                break;
            case 'mariadb':
            case 'mysql':
            default:
                $queryContext = new MySQLQueryContext();
                $dsn = 'mysql:host=' . $config['database_host'] . ';port=' . $config['database_port'] . ';dbname=' . $config['database_name'];
        }

        $this->setConnection(new Connection(new \PDO($dsn, $config['database_user'], $config['database_pwd'])));
        $this->setContext($queryContext);
    }

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

    /**
     * Query select where condition.
     *
     * @param array $where
     * @return DriverInterface
     */
    public function where(array $where)
    {
        // TODO: Implement where() method.
    }

    /**
     * Query fields.
     *
     * @param array $field
     * @return DriverInterface
     */
    public function field(array $field = ['*'])
    {
        // TODO: Implement field() method.
    }

    /**
     * Select join.
     *
     * @param        $table
     * @param        $on
     * @param string $type
     * @return DriverInterface
     */
    public function join($table, $on, $type = 'LEFT')
    {
        // TODO: Implement join() method.
    }

    /**
     * Select to table name.
     *
     * @param $table
     * @return DriverInterface
     */
    public function table($table)
    {
        // TODO: Implement table() method.
    }

    /**
     * @param $offset
     * @param $limit
     * @return DriverInterface
     */
    public function limit($offset, $limit)
    {
        // TODO: Implement limit() method.
    }

    /**
     * @param array $groupBy
     * @return DriverInterface
     */
    public function groupBy(array $groupBy)
    {
        // TODO: Implement groupBy() method.
    }

    /**
     * @param array $orderBy
     * @return DriverInterface
     */
    public function orderBy(array $orderBy)
    {
        // TODO: Implement orderBy() method.
    }

    /**
     * @param array $having
     * @return DriverInterface
     */
    public function having(array $having)
    {
        // TODO: Implement having() method.
    }

    /**
     * @param array $like
     * @return DriverInterface
     */
    public function like(array $like)
    {
        // TODO: Implement like() method.
    }

    /**
     * @param array $between
     * @return DriverInterface
     */
    public function between(array $between)
    {
        // TODO: Implement between() method.
    }

    /**
     * @param $sql
     * @return DriverInterface
     */
    public function createQuery($sql)
    {
        // TODO: Implement createQuery() method.
    }
}