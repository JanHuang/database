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

namespace FastD\Database\Drivers\Query\Paging;

use FastD\Database\Drivers\DriverInterface;
use FastD\Database\Drivers\Query\QueryBuilderInterface;

/**
 * Class QueryPagination
 *
 * @package FastD\Database\Pagination
 */
class Pagination
{
    /**
     * @var DriverInterface
     */
    private $driver;

    /**
     * The query or custom total row.
     *
     * @var int
     */
    protected $totalRows = 0;

    /**
     * The pagination show all page number.
     *
     * @var int
     */
    protected $totalPages = 0;

    /**
     * @var int
     */
    protected $offset = 0;

    /**
     * @var int
     */
    protected $showList = 25;

    /**
     * @var int
     */
    protected $showPage = 5;

    /**
     * @var int
     */
    protected $currentPage = 1;

    /**
     * @var null|int
     */
    protected $lastId;

    /**
     * @var null|array
     */
    protected $result;

    /**
     * @param null $driverOrTotal
     * @param int  $currentPage
     * @param int  $showList
     * @param int  $showPage
     * @param null $lastId
     */
    public function __construct($driverOrTotal = null, $currentPage = 1, $showList = 25, $showPage = 5, $lastId = null)
    {
        $this->initialize($driverOrTotal, $currentPage, $showList, $showPage, $lastId);
    }

    /**
     * @param DriverInterface|int|null   $driverOrTotal
     * @param int               $currentPage
     * @param int               $showList
     * @param int               $showPage
     * @param null              $lastId
     */
    public function initialize($driverOrTotal = null, $currentPage = 1, $showList = 25, $showPage = 5, $lastId = null)
    {
        if ($driverOrTotal instanceof DriverInterface) {
            $this->driver = $driverOrTotal;
            $this->totalRows = $this->fetchQueryContextTotalRows(clone $driverOrTotal->getQueryContext());
        } else if (is_numeric($driverOrTotal)) {
            $this->totalRows = $driverOrTotal;
        }

        // initialize attribute
        $this->currentPage = $currentPage;

        $this->showList = $showList;

        $this->showPage = $showPage;

        $this->lastId = $lastId;

        $this->totalPages = ceil($this->totalRows / $this->showList);

        $this->offset = ($this->currentPage - 1) * $this->showList;
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
    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    /**
     * @param int $page
     * @return $this
     */
    public function setCurrentPage($page)
    {
        $this->currentPage = $page;

        return $this;
    }

    /**
     * @param int $page
     * @return QueryPagination
     */
    public function page($page)
    {
        return $this->setCurrentPage($page);
    }

    /**
     * @param $showList
     * @return $this
     */
    public function setShowList($showList)
    {
        $this->showList = $showList;

        return $this;
    }

    /**
     * @return int
     */
    public function getShowList()
    {
        return $this->showList;
    }

    /**
     * @param $showPage
     * @return $this
     */
    public function setShowPage($showPage)
    {
        $this->showPage = $showPage;

        return $this;
    }

    /**
     * @return int
     */
    public function getShowPage()
    {
        return $this->showPage;
    }

    /**
     * @param $total
     * @return $this
     */
    public function setTotalRows($total)
    {
        $this->totalRows = $total;

        return $this;
    }

    /**
     * @param QueryContextInterface $context
     * @return array|bool|mixed
     */
    public function fetchQueryContextTotalRows(QueryBuilderInterface $queryBuilderInterface)
    {
        $sql = $queryBuilderInterface->limit(0,1)->fields(['COUNT(1) as total'])->select()->getSql();
        return $this->driver->createQuery($sql)->getQuery()->getOne('total');
    }

    /**
     * @return int
     */
    public function getTotalRows()
    {
        return $this->totalRows;
    }

    /**
     * @return int
     */
    public function getTotalPages()
    {
        return $this->totalPages;
    }

    /**
     * @param int $totalPages
     * @return $this
     */
    public function setTotalPages($totalPages)
    {
        $this->totalPages = $totalPages;

        return $this;
    }

    /**
     * @return array
     */
    public function getPageList()
    {
        if ($this->totalPages == 0) {
            return [];
        }

        $step = floor($this->showPage / 2);

        $start = $this->currentPage - $step;

        $end = $this->currentPage + $step;

        if ($this->totalPages > $this->showPage) {
            if ($start <= 1) {
                $start = 1;
                $end = $this->showPage;
            }

            if ($end >= $this->totalPages) {
                $end = $this->totalPages;
                $start = $this->totalPages - ($this->showPage - 1);
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
        $prev = $this->currentPage - 1;

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
        $next = $this->currentPage + 1;

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
        if (null !== $this->result || !($this->driver instanceof Driver)) {
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
            $context->limit($this->showList);
        } else {
            $context->limit($this->showList, $this->offset);
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

    public function getQueryString()
    {
        return null === $this->driver ? null : $this->driver->getQueryString();
    }
}