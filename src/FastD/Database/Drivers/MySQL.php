<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/12/13
 * Time: 上午11:10
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Database\Drivers;

/**
 * Class MySQL
 *
 * @package FastD\Database\Drivers
 */
class MySQL extends DriverAbstract
{
    /**
     * MySQL constructor.
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->setConnection(new MySQLConnection($config));
        $this->setContext(new MysqlQueryContext());
    }

    public function where($where)
    {
        $this->context->where($where);

        return $this;
    }

    public function field(array $fields)
    {
        $this->context->field($fields);

        return $this;
    }

    public function limit($offset, $limit)
    {
        // TODO: Implement limit() method.
    }

    public function table($name)
    {
        // TODO: Implement table() method.
    }

    public function join($table, $join = 'LEFT')
    {
        // TODO: Implement join() method.
    }

    public function group()
    {
        // TODO: Implement group() method.
    }
}