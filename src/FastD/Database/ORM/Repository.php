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

use FastD\Database\Drivers\DriverInterface;
use FastD\Http\Request;

/**
 * Class Repository
 *
 * @package FastD\Database\Repository
 */
abstract class Repository
{
    /**
     * @var string
     */
    protected $table;

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
        return $this->fields;
    }

    /**
     * @return string
     */
    public function getEntity()
    {
        return $this->entity;
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
        $row = $this->driver
            ->table(
                $this->getTable()
            )
            ->where($where)
            ->field(array () === $field ? $this->getFields() : $field)
            ->find()
            ;

        return Entity::init(new $this->entity, $row, $this->getDriver());
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
        $list = $this->driver
            ->table(
                $this->getTable()
            )
            ->where($where)
            ->field($field)
            ->findAll()
        ;

        return Entity::initArray(new $this->entity, $list, $this->getDriver());
    }

    /**
     * Save row into table.
     *
     * @param array $data
     * @param array $params
     * @param array $where
     * @return bool|int
     */
    public function save(array $data = [], array $params = [], array $where = [])
    {
        return $this->driver
            ->table(
                $this->getTable()
            )
            ->save($data, $params, $where);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function bindRequest(Request $request)
    {
        if ($request->isMethod('post')) {
            $params = $request->request->all();
        } else {
            $params = $request->query->all();
        }

        return $this->bindRequestParams($params);
    }

    /**
     * @param array $params
     * @return array
     */
    public function bindRequestParams(array $params)
    {

    }
    
    /**
     * @param array $where
     * @param array $params
     * @return int|bool
     */
    public function count(array $where = [], array $params = [])
    {
        return $this->driver->table($this->getTable())->count($where, $params);
    }

    /**
     * @param string $sql
     * @return DriverInterface
     */
    public function createQuery($sql)
    {
        return $this->driver->createQuery($sql);
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
        return $this->driver->pagination($this->getTable(), $page, $showList, $showPage, $lastId);
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
     * @return \FastD\Database\Drivers\Query\QueryBuilderInterface
     */
    public function getQueryBuilder()
    {
        return $this->driver->getQueryBuilder();
    }
}