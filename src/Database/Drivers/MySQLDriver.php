<?php
/**
 *
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2016
 *
 * @link      https://www.github.com/janhuang
 * @link      http://www.fast-d.cn/
 */

namespace FastD\Database\Drivers;

use FastD\Database\ORM\Model;
use FastD\Database\Query\MySQLQueryBuilder;
use FastD\Database\Query\QueryBuilder;
use PDOStatement;
use PDO;

/**
 * Class MySQLDriver
 * @package FastD\Database\Drivers
 */
class MySQLDriver implements DriverInterface
{
    /**
     * @var PDO
     */
    protected $pdo;

    /**
     * @var PDOStatement
     */
    protected $statement;

    /**
     * @var string
     */
    protected $dbName;

    /**
     * @var QueryBuilder
     */
    protected $queryBuilder;

    /**
     * @var array
     */
    protected $parameters = [];

    /**
     * @var array
     */
    protected $config = [];

    /**
     * MySQLDriver constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->pdo = new \PDO(
            sprintf(
                'mysql:host=%s;port=%s;dbname=%s;charset=%s',
                $config['database_host'],
                $config['database_port'],
                $config['database_name'],
                $config['database_charset'] ?? DriverInterface::DEFAULT_CHARSET
            ),
            $config['database_user'],
            $config['database_pwd']
        );

        $this->pdo->setAttribute(PDO::ATTR_TIMEOUT, $config['database_timeout'] ?? DriverInterface::DEFAULT_TIMEOUT);

        $this->dbName = $config['database_name'];

        $this->config = $config;

        $this->queryBuilder = new MySQLQueryBuilder();
    }

    /**
     * @return string
     */
    public function getDbName()
    {
        return $this->dbName;
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @return \PDO
     */
    public function getPdo()
    {
        return $this->pdo;
    }

    /**
     * @return MySQLQueryBuilder
     */
    public function getQueryBuilder()
    {
        return $this->queryBuilder;
    }

    /**
     * @param $sql
     * @return DriverInterface
     */
    public function query($sql)
    {
        $this->statement = $this->pdo->prepare($sql);

        return $this;
    }

    /**
     * Execute prepare.
     *
     * @return $this
     */
    public function execute()
    {
        $this->statement->execute($this->parameters);
        // Reset bind parameters.
        $this->parameters = [];

        return $this;
    }

    /**
     * Get one row to PDOStatement.
     *
     * @param string|null $field
     * @return array|bool
     */
    public function getOne($field = null)
    {
        $row = $this->statement->fetch(PDO::FETCH_ASSOC);

        return null === $field ? $row : $row[$field];
    }

    /**
     * Get all row to PDOStatement.
     */
    public function getAll()
    {
        return $this->statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @return array|bool
     */
    public function getId()
    {
        return $this->pdo->lastInsertId();
    }

    /**
     * @return array|bool
     */
    public function getAffected()
    {
        return $this->statement->rowCount();
    }

    /**
     * @param array $parameters
     * @return $this
     */
    public function setParameter(array $parameters)
    {
        foreach ($parameters as $name => $value) {
            $this->parameters[':' . $name] = $value;
        }

        unset($parameters);

        return $this;
    }

    /**
     * Transaction callable function.
     *
     * @param callable $callable
     * @return mixed
     */
    public function transaction(callable $callable)
    {
        $this->pdo->beginTransaction();

        $result = $callable($this, $this->getQueryBuilder());

        $this->pdo->commit();

        return $result;
    }

    /**
     * Get table repository object.
     *
     * @param string $model
     * @return Model
     */
    public function getModel($model)
    {
        $model = str_replace(':', '\\', $model);

        if (!class_exists($model)) {
            throw new \InvalidArgumentException(sprintf('Repository class ["%s"] is not found.', $model));
        }

        return new $model($this);
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return null === $this->statement ? $this->pdo->errorInfo() : $this->statement->errorInfo();
    }

    /**
     * @return array
     */
    public function getLogs()
    {
        return $this->queryBuilder->getLogs();
    }
}