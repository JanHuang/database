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

namespace FastD\Database;

use FastD\Database\ORM\Repository;

/**
 * 主要在PDO之上简单封装一层,用于DAO层访问,隔离DAO操作.可在驱动上进行操作.
 * 驱动主要处理PDO层面工作,不负责QueryBuilder
 *
 * Class Driver
 *
 * @package FastD\Database\Drivers
 */
class Driver implements DriverInterface
{
    /**
     * @var \PDO
     */
    protected $pdo;

    /**
     * @var \PDOStatement
     */
    protected $statement;

    /**
     * @var
     */
    protected $query_builder;

    /**
     * @var array
     */
    protected $parameters = [];

    /**
     * Driver constructor.
     *
     * @param \PDO $PDO
     */
    public function __construct(\PDO $PDO = null)
    {
        $this->pdo = $PDO;
    }

    /**
     * @return \PDO
     */
    public function getPdo()
    {
        return $this->pdo;
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
        $row = $this->statement->fetch(\PDO::FETCH_ASSOC);

        return null === $field ? $row : $row[$field];
    }

    /**
     * Get all row to PDOStatement.
     */
    public function getAll()
    {
        return $this->statement->fetchAll(\PDO::FETCH_ASSOC);
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
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @param string $repository
     * @return Repository
     * @throws \InvalidArgumentException
     */
    public function getRepository($repository)
    {
        $repository = str_replace(':', '\\', $repository) . 'Repository';

        if (!class_exists($repository)) {
            throw new \InvalidArgumentException(sprintf('Repository class ["%s"] is not found.', $repository));
        }

        $repository = new $repository($this);

        return $repository;
    }

    /**
     * @return DriverError
     */
    public function getError()
    {
        return new DriverError(null === $this->statement ? $this->pdo->errorInfo() : $this->statement->errorInfo());
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->pdo = null;
        $this->statement = null;
        $this->parameters = [];
        $this->query_builder = null;
    }
}