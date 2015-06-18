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
    protected $group;
    protected $order;
    protected $having;
    protected $sql;

    public function __construct($table, array $where = [], array $fields = ['*'])
    {
        $this->initialize($table, $where, $fields);
    }

    public function initialize($table, array $where = [], array $fields = ['*'])
    {
        $this->table    = null;
        $this->where    = null;
        $this->fields   = ['*'];
        $this->limit    = null;
        $this->offset   = null;
        $this->join     = null;
        $this->sql      = null;
        $this->table    = $table;
        $this->where    = $this->where($where);
        $this->fields   = $this->fields($fields);
    }

    protected function where(array $where = [])
    {
        if (empty($where)) {
            return '';
        }
        
        return '';
    }

    protected function fields(array $fields = [])
    {
        if (empty($fields) || ['*'] == $fields) {
            return '*';
        }

        return '`' . implode('`, `', $fields) . '`';
    }

    public function group()
    {
        $this->sql .= ' GROUP BY ' . $this->group;

        return $this;
    }

    public function having()
    {
        $this->sql .= ' HAVING ' . $this->having;

        return $this;
    }

    public function limit($limit, $offset = null)
    {
        $this->sql .= ' LIMIT ' . (null === $offset ? '' : ($offset . ', ')) . $limit;

        return $this;
    }

    public function select()
    {
        $this->sql = sprintf('SELECT %s FROM %s', $this->fields, $this->table);

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

    public function __clone()
    {
        return $this;
    }
}