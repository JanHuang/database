<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/6/17
 * Time: 下午11:21
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace Dobee\Database\Query;

/**
 * Prototype query context.
 *
 * Class QueryContext
 *
 * @package Dobee\Database\Query
 */
class QueryContext
{
    protected $table;
    protected $where;
    protected $fields = ['*'];
    protected $limit;
    protected $offset;
    protected $join;
    protected $sql;

    public function __construct($table, array $where = [], array $fields = ['*'])
    {
        $this->initialize();

        $this->table = $table;

        $this->where = $where;

        $this->fields = $fields;
    }

    protected function initialize()
    {
        $this->table    = null;
        $this->where    = null;
        $this->fields   = ['*'];
        $this->limit    = null;
        $this->offset   = null;
        $this->join     = null;
        $this->sql      = null;
    }

    public function select()
    {
        $sql = 'SELECT %s FROM %s %s %s';

        $fields = implode(',', $this->fields);

        $this->sql = sprintf($sql, $fields, $this->table, '', '');

        return $this;
    }

    public function update()
    {
        return $this;
    }

    public function delete()
    {
        return $this;
    }

    public function insert()
    {
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSql()
    {
        return $this->sql;
    }

    public function getOffset()
    {

    }

    public function limit($limit = null, $offset = null)
    {
        return $this;
    }

    public function __clone()
    {
        $this->initialize();

        return $this;
    }
}