<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/12/13
 * Time: 上午11:09
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Database\Drivers;

interface DriverInterface
{
    public function setName($name);

    public function getName();

    public function where($where);

    public function field(array $fields);

    public function limit($offset, $limit);

    public function table($name);

    public function join($table, $join = 'LEFT');

    public function group();
}