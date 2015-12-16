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
use FastD\Database\Drivers\Query\QueryBuilderInterface;
use FastD\Database\ORM\Repository;

/**
 * Class DriverAbstract
 *
 * @package FastD\Database\Drivers
 */
abstract class Driver implements DriverInterface
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
     * @return QueryBuilderInterface
     */
    public function getQueryBuilder()
    {
        return $this->queryBuilder;
    }

    /**
     * @param QueryBuilderInterface $queryBuilderInterface
     * @return $this
     */
    public function setQueryBuilder(QueryBuilderInterface $queryBuilderInterface)
    {
        $this->queryBuilder = $queryBuilderInterface;

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
        $this->getQueryBuilder()->where($where);

        return $this;
    }

    /**
     * Query fields.
     *
     * @param array $field
     * @return DriverInterface
     */
    public function field(array $field = ['*'])
    {
        $this->getQueryBuilder()->fields($field);

        return $this;
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
        $this->getQueryBuilder()->join($table, $on, $type);

        return $this;
    }

    /**
     * Select to table name.
     *
     * @param $table
     * @return DriverInterface
     */
    public function table($table)
    {
        $this->getQueryBuilder()->table($table);

        return $this;
    }

    /**
     * @param $offset
     * @param $limit
     * @return DriverInterface
     */
    public function limit($offset, $limit)
    {
        $this->getQueryBuilder()->limit($offset, $limit);

        return $this;
    }

    /**
     * @param array $groupBy
     * @return DriverInterface
     */
    public function groupBy(array $groupBy)
    {
        $this->getQueryBuilder()->groupBy($groupBy);

        return $this;
    }

    /**
     * @param array $orderBy
     * @return DriverInterface
     */
    public function orderBy(array $orderBy)
    {
        $this->getQueryBuilder()->orderBy($orderBy);

        return $this;
    }

    /**
     * @param array $having
     * @return DriverInterface
     */
    public function having(array $having)
    {
        $this->getQueryBuilder()->having($having);

        return $this;
    }

    /**
     * @param array $like
     * @return DriverInterface
     */
    public function like(array $like)
    {
        $this->getQueryBuilder()->like($like);

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
        $this->getPDOStatement()->execute();

        return $this;
    }

    /**
     * Get one row to PDOStatement.
     */
    public function getOne()
    {
        return $this->getPDOStatement()->fetch(\PDO::FETCH_ASSOC);
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
     * @param array $params
     * @return array|bool
     */
    public function find(array $params = [])
    {
        $this->createQuery(
            $this->getQueryBuilder()->select()->getSql()
        );

        foreach ($params as $name => $param) {
            $this->setParameter($name, $param);
        }

        $this->getQuery();

        return $this->getOne();
    }

    /**
     * @param array $params
     * @return array|bool
     */
    public function findAll(array $params = [])
    {
        $this->createQuery(
            $this->getQueryBuilder()->select()->getSql()
        );

        foreach ($params as $name => $param) {
            $this->setParameter($name, $param);
        }

        $this->getQuery();

        return $this->getAll();
    }

    /**
     * @param array $data
     * @param array $params
     * @param array $where
     * @return int|bool If insert to be return last id. Or affected row.
     */
    public function save(array $data, array $params = [], array $where = [])
    {
        if (array() === $where) {
            $this->createQuery(
                $this->getQueryBuilder()->insert($data)->getSql()
            );

            foreach ($params as $name => $param) {
                $this->setParameter($name, $param);
            }

            $this->getQuery();

            return $this->getId();
        }

        $this->createQuery(
            $this->getQueryBuilder()->update($data, $where)->getSql()
        );

        foreach ($params as $name => $param) {
            $this->setParameter($name, $param);
        }

        $this->getQuery();

        return $this->getAffected();
    }

    /**
     * @param $name
     * @param $value
     * @return $this
     */
    public function setParameter($name, $value)
    {
        $this->getPDOStatement()->bindParam(':' . $name, $value);

        return $this;
    }

    /**
     * @param string $repository
     * @return Repository
     */
    public function getRepository($repository)
    {
        $repository = str_replace(':', '\\', $repository);

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
}