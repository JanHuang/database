<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/6/15
 * Time: 下午2:18
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Database\Pagination;

use FastD\Database\Driver\Driver;
use FastD\Database\Query\QueryContext;

/**
 * Class QueryPagination
 *
 * @package FastD\Database\Pagination
 */
class QueryPagination
{
    /**
     * @var int
     */
    protected $totalRows = 0;

    /**
     * @var int
     */
    protected $totalPages = 0;

    /**
     * @var Driver
     */
    private $driver;

    /**
     * @var int
     */
    protected $offset = 0;

    /**
     * @var int
     */
    protected $show = 5;

    /**
     * @var int
     */
    protected $page = 1;

    /**
     * @var null|int
     */
    protected $lastId;

    /**
     * @var null|array
     */
    protected $result;

    /**
     * @param Driver $driver
     * @param int    $page
     * @param int    $show
     * @param null   $lastId
     */
    public function __construct(Driver $driver, $page = 1, $show = 5, $lastId = null)
    {
        $this->driver = $driver;

        $this->show = empty($show) ? 5 : $show;

        $this->page = $page;

        $this->lastId = $lastId;

        $this->initialize();
    }

    /**
     * Initialize pagination.
     *
     * @return void
     */
    public function initialize()
    {
        $context = clone $this->driver->getQueryContext();

        $total = $this->getTotal($context);

        $this->totalPages = ceil($total / $this->show);

        $this->resetPageOffset();
    }

    /**
     * Reset pagination offset.
     *
     * @return void
     */
    public function resetPageOffset()
    {
        $this->offset = ($this->page - 1) * $this->show;
    }

    /**
     * @return int|null
     */
    public function getLastId()
    {
        if (null === $this->lastId) {
            $this->getResult();
        }

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
     * @return int
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * @param int $offset
     * @return $this
     */
    public function setOffset($offset)
    {
        $this->offset = $offset;

        return $this;
    }

    /**
     * @return int
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param int $page
     * @return $this
     */
    public function setPage($page)
    {
        $this->page = $page;

        $this->resetPageOffset();

        return $this;
    }

    /**
     * @param int $page
     * @return QueryPagination
     */
    public function page($page)
    {
        return $this->setPage($page);
    }

    /**
     * @param int $show
     * @return $this
     */
    public function setShow($show)
    {
        $this->show = $show;

        return $this;
    }

    /**
     * @return int
     */
    public function getShow()
    {
        return $this->show;
    }

    /**
     * @param $total
     * @return $this
     */
    public function setTotal($total)
    {
        $this->totalRows = $total;

        return $this;
    }

    /**
     * @param QueryContext|null $context
     * @return array|bool|int|mixed
     */
    public function getTotal(QueryContext $context = null)
    {
        if (empty($this->totalRows) && null !== $context) {
            $sql = $context->limit(1)->fields(['COUNT(1) as total'])->select()->getSql();
            $this->totalRows = $this->driver->createQuery($sql)->getQuery()->getOne('total');
        }

        return $this->totalRows;
    }

    /**
     * @return array
     */
    public function getPageList()
    {
        if ($this->totalPages == 0) {
            return [];
        }

        $step = floor($this->show / 2);

        $start = $this->page - $step;

        $end = $this->page + $step;

        if ($this->totalPages > $this->show) {
            if ($start <= 1) {
                $start = 1;
                $end = $this->show;
            }

            if ($end >= $this->totalPages) {
                $end = $this->totalPages;
                $start = $this->totalPages - ($this->show - 1);
            }
        } else {
            $start = 1;
            $end = $this->totalPages;
        }

        return range((int)$start, (int)$end, 1);
    }

    /**
     * @return int
     */
    public function getPrevPage()
    {
        $prev = $this->page - 1;

        if ($prev <= 0) {
            $prev = 1;
        }

        return $prev;
    }

    /**
     * @return int
     */
    public function getNextPage()
    {
        $next = $this->page + 1;

        if ($next >= $this->totalPages) {
            $next = $this->totalPages;
        }

        return $next;
    }

    /**
     * @return int
     */
    public function getFirstPage()
    {
        return 1;
    }

    /**
     * @return int
     */
    public function getLastPage()
    {
        return $this->totalPages;
    }

    /**
     * @return array|bool
     */
    public function getResult()
    {
        if (null !== $this->result) {
            return $this->result;
        }

        $context = $this->driver->getQueryContext();

        if (null !== $this->lastId) {
            if (!empty($context->where)) {
                $joint = ' AND ';
            } else {
                $joint = ' WHERE ';
            }
            $context->where .= $joint . '`id` > ' . $this->lastId;
            $context->limit($this->show);
        } else {
            $context->limit($this->show, $this->offset);
        }

        $sql = $context->select()->getSql();

        $result = $this->driver->createQuery($sql)->getQuery()->getAll();

        $last = end($result);

        $this->lastId = isset($last['id']) && $this->totalPages > 1 ? $last['id'] : 0;

        unset($last, $context);

        $this->result = $result;
        unset($result);
        return $this->result;
    }
}