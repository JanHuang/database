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

namespace FastD\Database\Connection\Mysql;

use FastD\Database\Connection\Connection;

use FastD\Database\QueryContext\QueryContextInterface;

/**
 * Class MysqlConnection
 *
 * @package FastD\Kernel\Configuration\pdos\Db\Mysql
 */
class MysqlConnection extends Connection
{
    /**
     * @var QueryContextInterface
     */
    protected $queryContext;


    public function __construct(array $config = [], QueryContextInterface $contextInterface)
    {
        $this->queryContext = $contextInterface;
        $dsn = 'mysql:host=' . $config['database_host'] . ';port=' . $config['database_port'] . ';dbname=' . $config['database_name'];
        $this->pdo = new \PDO($dsn, $config['database_user'], $config['database_pwd']);
        $this->pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
        $this->pdo->exec('SET NAMES ' . (isset($config['database_charset']) ? $config['database_charset'] : 'utf8'));
    }

    /**
     * Start database transaction.
     *
     * @return bool
     */
    public function beginTransaction()
    {
        return $this->pdo->beginTransaction();
    }

    /**
     * Commit database transaction.
     *
     * @return bool
     */
    public function commit()
    {
        return $this->pdo->commit();
    }

    /**
     * Transaction error. Transaction rollback.
     *
     * @return bool
     */
    public function rollback()
    {
        return $this->pdo->rollBack();
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
        $this->statement = $this->pdo->prepare($sql);

        $this->logs[] = $sql;

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
    public function getAll()
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
        return null === $this->statement ? $this->pdo->errorInfo() : $this->statement->errorInfo();
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
        return $this->logs;
    }

    /**
     * @return void
     */
    public function close()
    {
        $this->pdo = null;
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
                    'pdo'            => 'pdo_NAME',
                    'client version'    => 'CLIENT_VERSION',
                    'connection status' => 'CONNECTION_STATUS',
                    'server info'       => 'SERVER_INFO',
                    'server version'    => 'SERVER_VERSION',
                    'timeout'           => 'TIMEOUT',
                 ] as $name => $value) {
            $attributes .= $name . ': ' . $this->pdo->getAttribute(constant('PDO::ATTR_' . $value)) . PHP_EOL;
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
        return $this->pdo->lastInsertId();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getConnectionInfo();
    }
}