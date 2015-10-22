<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/3/12
 * Time: 上午11:15
 * Github: https://www.github.com/janhuang 
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 */

namespace FastD\Database\ORM;

use FastD\Database\Driver\Driver;

/**
 * Class Repository
 *
 * @package FastD\Database\Repository
 */
class Repository
{
    /**
     * @var
     */
    protected $table;

    /**
     * @var Driver
     */
    protected $connection;

    /**
     * @var array
     */
    protected $fields;

    /**
     * @var array
     */
    protected $keys;

    /**
     * @var string
     */
    protected $entity;

    /**
     * @param Driver $driver
     */
    public function __construct(Driver $driver = null)
    {
        $this->connection = $driver;
    }

    /**
     * Return mapping database table full name.
     *
     * @return string
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @return array
     */
    public function getFields()
    {
        return null === $this->fields ? [] : $this->fields;
    }

    /**
     * Fetch one row.
     *
     * @param array $where
     * @param array $field
     * @return object The found object.
     */
    public function find(array $where = [], array $field = [])
    {
        return $this->connection->find($this->getTable(), $where, $field);
    }

    /**
     * Fetch all rows.
     *
     * @param array $where
     * @param array|string $field
     * @return object The found object.
     */
    public function findAll(array $where = [],  array $field = [])
    {
        return $this->connection->findAll($this->getTable(), $where, $field);
    }

    /**
     * @param array $where
     * @return int|bool
     */
    public function count(array $where = [])
    {
        return $this->connection->count($this->getTable(), $where);
    }

    /**
     * @param $dql
     * @return Driver
     */
    public function createQuery($dql)
    {
        return $this->connection->createQuery($dql);
    }

    /**
     * @param int  $page
     * @param int  $showList
     * @param int  $showPage
     * @param null $lastId
     * @return \FastD\Database\Pagination\QueryPagination
     */
    public function pagination($page = 1, $showList = 25, $showPage = 5, $lastId = null)
    {
        return $this->connection->pagination($this->getTable(), $page, $showList, $showPage, $lastId);
    }

    /**
     * Method persist alias.
     *
     * @param $entity
     * @return void
     */
    public function save(&$entity)
    {
        $this->persist($entity);
    }

    /**
     * Encapsulates a simple layer of ORM.
     *
     * Insert、Update、Delete or IMPORTQ operation.
     * It's return entity.
     * Get information from this param entity.
     *
     * @param $entity
     * @return void
     * @throws \InvalidArgumentException
     */
    public function persist(&$entity)
    {
        if (!($entity instanceof $this->entity)) {
            throw new \InvalidArgumentException(sprintf('The parameters type should be use "%s"', $this->entity));
        }

        $data = [];

        foreach ($this->fields as $filed) {

        }


    }

    /**
     * Return query errors.
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->connection->getErrors();
    }

    /**
     * Return last query log.
     *
     * @return string
     */
    public function getLastQuery()
    {
        return $this->connection->getQueryString();
    }

    /**
     * Return all query logs.
     *
     * @return array
     */
    public function getQueryLogs()
    {
        return $this->connection->getLogs();
    }
}