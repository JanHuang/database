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

namespace FastD\Database\Drivers\Query;

/**
 * Class MySQLQueryContext
 *
 * @package FastD\Database\Drivers\QueryContext
 */
class MySQLQueryBuilder implements QueryBuilderInterface
{
    /**
     * @var string
     */
    protected $table;

    /**
     * @var string
     */
    protected $where;

    /**
     * @var string
     */
    protected $fields = '*';

    /**
     * @var string
     */
    protected $limit;

    /**
     * @var string
     */
    protected $join;

    /**
     * @var string
     */
    protected $group;

    /**
     * @var string
     */
    protected $order;

    /**
     * @var string
     */
    protected $like;

    /**
     * @var string
     */
    protected $not_like;

    /**
     * @var string
     */
    protected $having;

    /**
     * @var string
     */
    protected $value;

    /**
     * @var string
     */
    protected $keys;

    /**
     * @var string
     */
    protected $sql;

    /**
     * @var array
     */
    protected $logs = [];

    /**
     * @const int
     */
    const CONTEXT_INSERT = 1;

    /**
     * @const int
     */
    const CONTEXT_UPDATE = 2;

    /**
     * @const int
     */
    const CONTEXT_DELETE = 3;

    /**
     * @param array $where
     * @param string $assign
     * @return string
     */
    protected function parseWhere(array $where, $assign = '=')
    {
        if (empty($where)) {
            return '';
        }

        $conditions = reset($where);

        $joint = '';

        if (is_array($conditions)) {
            $jointArr = array_keys($where);
            $joint = $jointArr[0];
            unset($jointArr);
        } else {
            $conditions = $where;
        }

        $where = [];

        foreach ($conditions as $key => $value) {
            if (false !== ($start = strpos($key, '['))) {
                $assign = substr($key, $start + 1, -1);
                $key = substr($key, 0, $start);
            }

            if (0 !== strpos($value, ':')) {
                $value = '\'' . $value . '\'';
            }
            $where[] = '`' . $key . '`' . $assign . $value;
        }

        if ('' !== $joint) {
            $joint = ' ' . $joint . ' ';
        }

        return implode($joint, $where);
    }

    /**
     * @param array $data
     * @param int   $operation
     * @return $this
     */
    public function data(array $data, $operation = self::CONTEXT_UPDATE)
    {
        switch ($operation) {
            case self::CONTEXT_INSERT:
                $keys = array_keys($data);
                $values = array_values($data);
                $this->keys = '(`' . implode('`,`', $keys) . '`)';
                $this->value = '(\'' . implode('\',\'', $values) . '\')';
                break;
            case self::CONTEXT_UPDATE:
            default:
                $values = [];
                foreach ($data as $name => $value) {
                    $values[] = '`' . $name . '`=\'' . $value . '\'';
                }
                $this->value = implode(',', $values);
        }

        return $this;
    }

    /**
     * @param $table
     * @return $this
     */
    public function table($table)
    {
        $this->table = str_replace('``', '`', '`' . $table . '`');

        return $this;
    }

    /**
     * @param array $where
     * @return $this
     */
    public function where(array $where = [])
    {
        $where = $this->parseWhere($where);

        if ('' != $where) {
            $this->where = ' WHERE ' . $where;
        }

        return $this;
    }

    /**
     * @param array $fields
     * @return $this
     */
    public function fields(array $fields = [])
    {
        if (array() !== $fields) {
            $this->fields = '';
            foreach ($fields as $name => $alias) {
                if (is_integer($name)) {
                    if (false === strpos($alias, ' ')) {
                        $this->fields .= '`' . $alias . '`,';
                    } else {
                        $this->fields .= $alias . ',';
                    }
                } else {
                    $this->fields .= '`' . $name . '` AS `' . $alias . '`,';
                }
            }
            $this->fields = trim($this->fields, ',');
        } else {
            $this->fields = '*';
        }

        return $this;
    }

    /**
     * @param array $having
     * @return $this
     */
    public function having(array $having)
    {
        $this->having = ' HAVING ' . $this->parseWhere($having);

        return $this;
    }

    /**
     * @param null $limit
     * @param null $offset
     * @return $this
     */
    public function limit($limit = null, $offset = null)
    {
        $this->limit = null;

        if (null !== $limit) {
            $this->limit = ' LIMIT ' . (null === $offset ? '' : ($offset . ',')) . $limit;
        }

        return $this;
    }

    /**
     * Select join.
     *
     * @param        $table
     * @param        $on
     * @param string $type
     * @return $this
     */
    public function join($table, $on, $type = 'LEFT')
    {
        $this->join = ' ' . $type . ' JOIN ' . $table . ' ON ' . $on;

        return $this;
    }

    /**
     * @param array $groupBy
     * @return $this
     */
    public function groupBy(array $groupBy)
    {
        $this->group = ' GROUP BY `' . implode('`,`', $groupBy) . '`';

        return $this;
    }

    /**
     * @param array $orderBy
     * @return $this
     */
    public function orderBy(array $orderBy)
    {
        $orders = [];
        foreach ($orderBy as $field => $order) {
            if (!is_integer($field)) {
                $orders[] = '`' . $field . '` ' . $order;
            } else {
                $orders[] = $order;
            }
        }

        $this->order = ' ORDER BY ' . implode(',', $orders);
        unset($orders);
        return $this;
    }

    /**
     * @param array $like
     * @return $this
     */
    public function like(array $like)
    {
        $this->like = ' WHERE ' . $this->parseWhere($like, ' LIKE ');

        return $this;
    }

    /**
     * @param array $like
     * @return $this
     */
    public function notLike(array $like)
    {
        $this->not_like = ' WHERE ' . $this->parseWhere($like, ' NOT LIKE ');

        return $this;
    }

    /**
     * @param $sql
     * @return $this
     */
    public function custom($sql)
    {
        $this->sql = $sql;

        return $this;
    }

    /**
     * @return $this
     */
    public function select()
    {
        $this->sql = 'SELECT ' . $this->fields . ' FROM ' . $this->table . $this->where . $this->like . $this->group . $this->having . $this->order . $this->limit . ';';

        return $this;
    }

    /**
     * @return $this
     */
    public function update()
    {
        $this->sql = 'UPDATE ' . $this->table . ' SET ' . $this->value . $this->where . $this->limit . ';';

        return $this;
    }

    /**
     * @return $this
     */
    public function delete()
    {
        $this->sql = 'DELETE FROM ' . $this->table . $this->where . $this->limit . ';';

        return $this;
    }

    /**
     * @return $this
     */
    public function insert()
    {
        $this->sql = 'INSERT INTO ' . $this->table . $this->keys . ' VALUES ' . $this->value . ';';

        return $this;
    }

    /**
     * @return string
     */
    public function getSql()
    {
        $sql = $this->sql;

        $this->fields   = '*';
        $this->where    = null;
        $this->group    = null;
        $this->limit    = null;
        $this->having   = null;
        $this->order    = null;
        $this->keys     = null;
        $this->value    = null;
        $this->join     = null;

        $this->logs[] = $sql;

        return $sql;
    }

    /**
     * @return array
     */
    public function getLogs()
    {
        return $this->logs;
    }
}