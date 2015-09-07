<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/8/1
 * Time: 下午11:27
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Database\Tests\Repository;

use FastD\Database\Repository\Repository;

class DemoRepository extends Repository
{
    public function getFields()
    {
        return [
            'id' => 'int',
            'name' => 'string',
            'roles' => 'json',
        ];
    }
}