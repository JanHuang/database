<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/6/15
 * Time: 下午9:44
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace Dobee\Database\Driver;

use Dobee\Database\Query\QueryContext;

/**
 * Class MysqlDriver
 *
 * @package Dobee\Database\Driver
 */
class MysqlDriver extends PdoDriver
{
    /**
     * @param       $table
     * @param array $where
     * @param array $fields
     * @return \Dobee\Database\Query\QueryContext
     */
    public function createQueryContext($table, array $where, array $fields = ['*'])
    {
        return new QueryContext($table, $where, $fields);
    }
}