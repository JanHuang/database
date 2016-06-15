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

use FastD\Database\Orm\Repository;

/**
 * Class QueryPagination
 *
 * @package FastD\Database\Query\Paging
 */
class QueryPagination extends Pagination
{
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
     * QueryPagination constructor.
     * @param Repository $repository
     * @param int $currentPage
     * @param int $showList
     * @param int $showPage
     */
    public function __construct(Repository $repository, $currentPage = 1, $showList = 25, $showPage = 5)
    {
        parent::__construct($repository->count(), $currentPage, $showList, $showPage);

        $this->setResult($repository->limit($this->getShowList(), $this->getOffset())->findAll());
    }

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
     * @param array $result
     * @return $this
     */
    public function setResult(array $result)
    {
        $this->result = $result;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getResult()
    {
        return $this->result;
    }
}