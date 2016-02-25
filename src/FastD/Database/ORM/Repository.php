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

use FastD\Database\DriverInterface;
use FastD\Database\Drivers\Query\MySQLQueryBuilder;
use FastD\Database\Drivers\Query\Paging\Pagination;
use FastD\Database\Drivers\Query\QueryBuilderInterface;
use FastD\Database\Params\HttpRequestHandle;

/**
 * Class Repository
 *
 * @package FastD\Database\Repository
 */
abstract class Repository extends HttpRequestHandle
{
    const FIELDS = [];
    const ALIAS = [];
    const PRIMARY = '';

    /**
     * @var string
     */
    protected $table;

    /**
     * @var string
     */
    protected $entity;

    /**
     * @var DriverInterface
     */
    protected $driver;

    /**
     * @param DriverInterface $driverInterface
     */
    public function __construct(DriverInterface $driverInterface = null)
    {
        $this->setDriver($driverInterface);
    }

    /**
     * @return DriverInterface
     */
    public function getDriver()
    {
        return $this->driver;
    }

    /**
     * @param DriverInterface|null $driverInterface
     * @return $this
     */
    public function setDriver(DriverInterface $driverInterface = null)
    {
        $this->driver = $driverInterface;

        return $this;
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
        return static::FIELDS;
    }

    /**
     * @return array
     */
    public function getAlias()
    {
        return static::ALIAS;
    }

    /**
     * @return string
     */
    public function getPrimary()
    {
        return static::PRIMARY;
    }

    /**
     * Fetch one row.
     *
     * @param array $where
     * @param array $field
     * @return array The found object.
     */
    public function find(array $where = [], array $field = [])
    {
        return $this
            ->createQuery(
                $this
                    ->createQueryBuilder()
                    ->where($where)
                    ->fields(array() === $field ? $this->getAlias() : $field)
                    ->select()
            )
            ->getQuery()
            ->getOne()
            ;
    }

    /**
     * Fetch all rows.
     *
     * @param array        $where
     * @param array|string $field
     * @return array The found object.
     */
    public function findAll(array $where = [], array $field = [])
    {
        return $this
            ->createQuery(
                $this
                    ->createQueryBuilder()
                    ->where($where)
                    ->fields(array() === $field ? $this->getAlias() : $field)
                    ->select()
            )
            ->getQuery()
            ->getAll()
            ;
    }

    /**
     * Save row into table.
     *
     * @param array $data
     * @param array $where
     * @param array $params
     * @return bool|int
     */
    public function save(array $data = [], array $where = [], array $params = [])
    {
        if (empty($where)) {
            return $this
                ->createQuery(
                    $this->createQueryBuilder()
                        ->insert(array() === $data ? $this->data : $data)
                )
                ->setParameter([] === $params ? $this->params : $params)
                ->getQuery()
                ->getId();
        }

        return $this
            ->createQuery(
                $this
                    ->createQueryBuilder()
                    ->update(array() === $data ? $this->data : $data, $where)
            )
            ->setParameter([] === $params ? $this->params : $params)
            ->getQuery()
            ->getAffected()
            ;
    }

    /**
     * @param array $where
     * @return int|bool
     */
    public function count(array $where = [])
    {
        return (int)$this->find($where, ['count(id) as total'])['total'];
    }

    /**
     * @param string $sql
     * @return DriverInterface
     */
    public function createQuery($sql)
    {
        return $this->driver->query($sql);
    }

    /**
     * Return query errors.
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->driver->getErrors();
    }

    /**
     * @param string $table
     * @return QueryBuilderInterface
     */
    public function createQueryBuilder($table = null)
    {
        return MySQLQueryBuilder::factory()->table($table ?? $this->getTable());
    }

    /**
     * @param      $page
     * @param int  $showList
     * @param int  $showPage
     * @param null $lastId
     * @return Pagination
     */
    public function pagination($page = 1, $showList = 25, $showPage = 5, $lastId = null)
    {
        $pagination = new Pagination($this->getDriver(), $page, $showList, $showPage, $lastId);

        return $pagination->table($this->getTable())->fields($this->getAlias());
    }
}