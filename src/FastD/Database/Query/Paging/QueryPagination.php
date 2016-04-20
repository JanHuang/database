<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 16/4/19
 * Time: 下午11:34
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Database\Query\Paging;

use FastD\Database\DriverInterface;
use FastD\Database\Query\Mysql;

class QueryPagination extends Pagination
{
    /**
     * @var DriverInterface
     */
    private $driver;

    /**
     * @var array
     */
    protected $fields = [];

    /**
     * @var string
     */
    protected $table;

    /**
     * @var array
     */
    protected $orderBy = [];

    /**
     * @var array
     */
    protected $where = [];

    /**
     * @var null|int
     */
    protected $lastId;

    /**
     * @var null|array
     */
    protected $result;


    /**
     * @return int|null
     */
    public function getLastId()
    {
        return $this->lastId;
    }

    /**
     * @param int $lastId
     * @return $this
     */
    public function setLastId($lastId)
    {
        $this->lastId = $lastId;

        return $this;
    }

    /**
     * @param array $fields
     * @return $this
     */
    public function fields(array $fields)
    {
        $this->fields = $fields;

        return $this;
    }

    /**
     * @param $table
     * @return $this
     */
    public function table($table)
    {
        $this->table = $table;

        return $this;
    }

    /**
     * @param array $where
     * @return $this
     */
    public function where(array $where)
    {
        $where = array_merge($this->where, $where);

        $this->where = [];
        $this->where['AND'] = $where;

        return $this;
    }

    /**
     * @param array $orderBy
     * @return $this
     */
    public function orderBy(array $orderBy)
    {
        $this->orderBy = $orderBy;

        return $this;
    }

    /**
     * @return $this
     */
    public function getPagination()
    {
        if ($this->driver instanceof DriverInterface) {
            $this->totalRows = $this
                ->driver
                ->query(
                    Mysql::singleton()
                        ->from($this->table)
                        ->where($this->where)
                        ->fields(['count(1) as total'])->select()
                )
                ->execute()
                ->getOne('total')
            ;
            $this->result = $this
                ->driver
                ->query(
                    Mysql::singleton()
                        ->from($this->table)
                        ->fields($this->fields)
                        ->where($this->where)
                        ->orderBy($this->orderBy)
                        ->limit($this->getShowList(), $this->offset)
                        ->select()
                )
                ->execute()
                ->getAll()
            ;
            $end = end($this->result);
            $this->lastId = isset($end['id']) ? $end['id'] : null;
        }

        $this->totalPages = ceil($this->totalRows / $this->showList);

        return $this;
    }

    /**
     * @return array|null
     */
    public function getResult()
    {
        return $this->result;
    }

    /*
     *
     * if (null !== $lastId) {
            $this->where = ['id[>]' => $this->lastId];
        }*/
}