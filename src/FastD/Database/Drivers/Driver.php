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

use FastD\Database\Drivers\Query\MySQLQueryBuilder;
use FastD\Database\ORM\Repository;

/**
 * Class DriverAbstract
 *
 * @package FastD\Database\Drivers
 */
class Driver implements DriverInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var \PDO
     */
    protected $pdo;

    /**
     * @var \PDOStatement
     */
    protected $pdo_statement;

    /**
     * @var MySQLQueryBuilder
     */
    protected $queryBuilder;

    /**
     * @var array
     */
    protected $parameters = [];

    /**
     * Driver constructor.
     * @param \PDO $PDO
     * @param null $name
     */
    public function __construct(\PDO $PDO, $name = null)
    {
        $this->pdo = $PDO;

        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return \PDO
     */
    public function getPDO()
    {
        return $this->pdo;
    }

    /**
     * @param \PDO $PDO
     * @return $this
     */
    public function setPDO(\PDO $PDO)
    {
        $this->pdo = $PDO;

        return $this;
    }

    /**
     * @return \PDOStatement
     */
    public function getPDOStatement()
    {
        return $this->pdo_statement;
    }

    /**
     * @param \PDOStatement $PDOStatement
     * @return $this
     */
    public function setPDOStatement(\PDOStatement $PDOStatement)
    {
        $this->pdo_statement = $PDOStatement;

        return $this;
    }

    /**
     * @param $sql
     * @return DriverInterface
     */
    public function createQuery($sql)
    {
        $this->setPDOStatement(
            $this->getPDO()->prepare($sql)
        );

        return $this;
    }

    /**
     * @return $this
     */
    public function getQuery()
    {
        $this->getPDOStatement()->execute($this->parameters);

        $this->parameters = [];

        return $this;
    }

    /**
     * Get one row to PDOStatement.
     *
     * @param string|null $name
     * @return array|bool
     */
    public function getOne($name = null)
    {
        $row = $this->getPDOStatement()->fetch(\PDO::FETCH_ASSOC);

        return null === $name ? $row : $row[$name];
    }

    /**
     * Get all row to PDOStatement.
     */
    public function getAll()
    {
        return $this->getPDOStatement()->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @return array|bool
     */
    public function getId()
    {
        return $this->getPDO()->lastInsertId();
    }

    /**
     * @return array|bool
     */
    public function getAffected()
    {
        return $this->getPDOStatement()->rowCount();
    }

    /**
     * @param array|string $name
     * @param $value
     * @return $this
     */
    public function setParameter($name, $value = null)
    {
        if (is_string($name) && null !== $value) {
            $params[$name] = $value;
        } else {
            $params = $name;
        }

        foreach ($params as $name => $value) {
            $this->parameters[':' . $name] = $value;
        }

        return $this;
    }

    /**
     * @param string $repository
     * @return Repository
     */
    public function getRepository($repository)
    {
        $repository = str_replace(':', '\\', $repository) . 'Repository';

        $repository = new $repository;

        $repository->setDriver($this);

        return $repository;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return null === $this->getPDOStatement() ? $this->getPDO()->errorInfo() : $this->getPDOStatement()->errorInfo();
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->pdo = null;
        $this->pdo_statement = null;
    }

    /**
     * @param $name
     * @return DriverInterface
     */
    public function setName($name)
    {
        // TODO: Implement setName() method.
    }
}