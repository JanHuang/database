<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/12/12
 * Time: 下午5:35
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Database\Drivers\QueryContext;

/**
 * Interface QueryContextInterface
 *
 * @package FastD\Database\Drivers\QueryContext
 */
interface QueryContextInterface
{
    /**
     * Query select where condition.
     *
     * @param array $where
     * @return QueryContextInterface
     */
    public function where(array $where);

    /**
     * Query fields.
     *
     * @param array $field
     * @return QueryContextInterface
     */
    public function fields(array $field = ['*']);

    /**
     * Select join.
     *
     * @param        $table
     * @param        $on
     * @param string $type
     * @return QueryContextInterface
     */
    public function join($table, $on, $type = 'LEFT');

    /**
     * Select to table name.
     *
     * @param $table
     * @return QueryContextInterface
     */
    public function table($table);

    /**
     * @param $offset
     * @param $limit
     * @return QueryContextInterface
     */
    public function limit($offset, $limit);

    /**
     * @param array $groupBy
     * @return QueryContextInterface
     */
    public function groupBy(array $groupBy);

    /**
     * @param array $orderBy
     * @return QueryContextInterface
     */
    public function orderBy(array $orderBy);

    /**
     * @param array $having
     * @return QueryContextInterface
     */
    public function having(array $having);

    /**
     * @param array $like
     * @return QueryContextInterface
     */
    public function like(array $like);

    /**
     * @param array $like
     * @return QueryContextInterface
     */
    public function notLike(array $like);

    /**
     * @param $sql
     * @return QueryContextInterface
     */
    public function custom($sql);
}