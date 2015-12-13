<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/12/12
 * Time: 下午5:37
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Database\Drivers\QueryContext;

/**
 * Class QueryContext
 *
 * @package FastD\Database\Drivers\QueryContext
 */
class QueryContext implements QueryContextInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @param $name
     */
    public function setName($name)
    {
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
     * @return $this
     */
    public function __clone()
    {
        return $this;
    }

    /**
     * Query select where condition.
     *
     * @param array $where
     * @return QueryContextInterface
     */
    public function where(array $where)
    {
        // TODO: Implement where() method.
    }

    /**
     * Query fields.
     *
     * @param array $field
     * @return QueryContextInterface
     */
    public function field(array $field = ['*'])
    {
        // TODO: Implement field() method.
    }

    /**
     * Select join.
     *
     * @param        $table
     * @param        $on
     * @param string $type
     * @return QueryContextInterface
     */
    public function join($table, $on, $type = 'LEFT')
    {
        // TODO: Implement join() method.
    }

    /**
     * Select to table name.
     *
     * @param $table
     * @return QueryContextInterface
     */
    public function table($table)
    {
        // TODO: Implement table() method.
    }

    /**
     * @param $offset
     * @param $limit
     * @return QueryContextInterface
     */
    public function limit($offset, $limit)
    {
        // TODO: Implement limit() method.
    }

    /**
     * @param array $groupBy
     * @return QueryContextInterface
     */
    public function groupBy(array $groupBy)
    {
        // TODO: Implement groupBy() method.
    }

    /**
     * @param array $orderBy
     * @return QueryContextInterface
     */
    public function orderBy(array $orderBy)
    {
        // TODO: Implement orderBy() method.
    }

    /**
     * @param array $having
     * @return QueryContextInterface
     */
    public function having(array $having)
    {
        // TODO: Implement having() method.
    }

    /**
     * @param array $like
     * @return QueryContextInterface
     */
    public function like(array $like)
    {
        // TODO: Implement like() method.
    }

    /**
     * @param array $between
     * @return QueryContextInterface
     */
    public function between(array $between)
    {
        // TODO: Implement between() method.
    }

    /**
     * @param $sql
     * @return QueryContextInterface
     */
    public function custom($sql)
    {
        // TODO: Implement custom() method.
    }
}