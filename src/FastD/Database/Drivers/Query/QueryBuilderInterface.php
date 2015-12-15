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

namespace FastD\Database\Drivers\Query;

/**
 * Interface $this
 *
 * @package FastD\Database\Drivers\QueryContext
 */
interface QueryBuilderInterface
{
    /**
     * Query select where condition.
     *
     * @param array $where
     * @return $this
     */
    public function where(array $where);

    /**
     * Query fields.
     *
     * @param array $field
     * @return $this
     */
    public function fields(array $field = ['*']);

    /**
     * Select join.
     *
     * @param        $table
     * @param        $on
     * @param string $type
     * @return $this
     */
    public function join($table, $on, $type = 'LEFT');

    /**
     * Select to table name.
     *
     * @param $table
     * @return $this
     */
    public function table($table);

    /**
     * @param $offset
     * @param $limit
     * @return $this
     */
    public function limit($offset, $limit);

    /**
     * @param array $groupBy
     * @return $this
     */
    public function groupBy(array $groupBy);

    /**
     * @param array $orderBy
     * @return $this
     */
    public function orderBy(array $orderBy);

    /**
     * @param array $having
     * @return $this
     */
    public function having(array $having);

    /**
     * @param array $like
     * @return $this
     */
    public function like(array $like);

    /**
     * @param array $like
     * @return $this
     */
    public function notLike(array $like);

    /**
     * @param $sql
     * @return $this
     */
    public function custom($sql);

//    public function func();

//    public function subQuery();
}