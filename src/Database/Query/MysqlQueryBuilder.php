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

namespace FastD\Database\Query;

/**
 * Class Mysql
 *
 * @package FastD\Database\Query
 */
class MySQLQueryBuilder extends QueryBuilder
{
    /**
     * @param array $where
     * @param string $assign
     * @return string
     */
    protected function parseWhere(array $where, $assign = '=')
    {
        $conditions = reset($where);
        $joint = '';

        if (is_array($conditions)) {
            $jointArr = array_keys($where);
            $joint = $jointArr[0]; // set assign
            unset($jointArr);
        } else {
            $conditions = $where;
        }

        $where = [];
        foreach ($conditions as $key => $value) {
            if (false !== ($start = strpos($key, '['))) {
                $end = strpos($key, ']');
                $assign = substr($key, $start + 1, $end - $start - 1);
                $key = substr($key, $end + 1);
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
    protected function data(array $data, $operation = self::BUILDER_UPDATE)
    {
        switch ($operation) {
            case self::BUILDER_INSERT:
                $keys = array_keys($data);
                $values = array_values($data);
                $this->keys = '(`' . implode('`,`', $keys) . '`)';
                foreach ($values as $name => $value) {
                    if (false === strpos($value, ':')) {
                        $values[$name] = '\'' . $value . '\'';
                    }
                }
                $this->value = '(' . implode(',', $values) . ')';
                break;
            case self::BUILDER_UPDATE:
            default:
                $values = [];
                foreach ($data as $name => $value) {
                    if (false === strpos($value, ':')) {
                        $value = '\'' . $value . '\'';
                    }

                    $values[] = '`' . $name . '`=' . $value;
                }
                $this->value = implode(',', $values);
        }

        return $this;
    }

    /**
     * @param $table
     * @param null $alias
     * @return $this
     */
    public function from($table, $alias = null)
    {
        $this->table = '`' . $table . '`';

        if (null !== $alias) {
            $this->table .= ' AS `' . $alias . '`';
        }

        return $this;
    }

    /**
     * @param array $where
     * @return $this
     */
    public function where(array $where = [])
    {
        if (null != ($where = $this->parseWhere($where))) {
            $this->where = ' WHERE ' . $where;
            unset($where);
        }

        return $this;
    }

    /**
     * @param array $fields
     * @return $this
     */
    public function fields(array $fields)
    {
        $this->fields = '';

        foreach ($fields as $name => $alias) {
            if (is_integer($name)) {
                if (false === strpos($alias, '(')) {
                    $alias = '`' . $alias . '`,';
                }
                $str = $alias;
            } else {
                if (false === strpos($name, '(')) {
                    $alias = '`'. $name . '` AS `' . $alias . '`,';
                } else {
                    $alias = $name . ' AS `' . $alias . '`,';
                }
                $str = $alias;
            }

            $this->fields .= $str;
        }

        $this->fields = trim($this->fields, ',');

        return $this;
    }

    /**
     * @param array $having
     * @return $this
     */
    public function having(array $having)
    {
        if (!empty($having)) {
            $this->having = ' HAVING ' . $this->parseWhere($having);
        }

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
        if (!empty($groupBy)) {
            $this->group = ' GROUP BY `' . implode('`,`', $groupBy) . '`';
        }

        return $this;
    }

    /**
     * @param array $orderBy
     * @return $this
     */
    public function orderBy(array $orderBy)
    {
        if (!empty($orderBy)) {
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
        }

        return $this;
    }

    /**
     * @param array $like
     * @return $this
     */
    public function like(array $like)
    {
        if (!empty($like)) {
            $this->like = ' WHERE ' . $this->parseWhere($like, ' LIKE ');
        }

        return $this;
    }

    /**
     * @param array $like
     * @return $this
     */
    public function notLike(array $like)
    {
        if (!empty($like)) {
            $this->like = ' WHERE ' . $this->parseWhere($like, ' NOT LIKE ');
        }

        return $this;
    }

    /**
     * @param array $fields
     * @return string
     */
    public function select(array $fields = [])
    {
        if (!empty($fields)) {
            $this->fields($fields);
        }

        $this->sql = 'SELECT ' . $this->fields . ' FROM ' . $this->table . $this->where . $this->like . $this->group . $this->having . $this->order . $this->limit . ';';

        return $this->getSql();
    }

    /**
     * @param array $data
     * @param array $where
     * @return string
     */
    public function update(array $data, array $where = [])
    {
        $this->data($data, self::BUILDER_UPDATE);

        $this->where($where);

        $this->sql = 'UPDATE ' . $this->table . ' SET ' . $this->value . $this->where . $this->limit . ';';

        return $this->getSql();
    }

    /**
     * @param array $where
     * @return string
     */
    public function delete(array $where)
    {
        $this->where($where);

        $this->sql = 'DELETE FROM ' . $this->table . $this->where . $this->limit . ';';

        return $this->getSql();
    }

    /**
     * @param array $data
     * @return string
     */
    public function insert(array $data)
    {
        $this->data($data, self::BUILDER_INSERT);

        $this->sql = 'INSERT INTO ' . $this->table . $this->keys . ' VALUES ' . $this->value . ';';

        return $this->getSql();
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