<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 16/2/25
 * Time: 下午6:20
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Database\Tests\Builder;

use FastD\Database\Builder\Field;
use FastD\Database\Builder\Table;

class TableTest extends \PHPUnit_Framework_TestCase
{
    public function testBase()
    {
        $table = new Table('demo', [
            new Field('name', 'varchar')
        ]);

        $this->assertEquals($table->getTable(), 'demo');
    }
}
