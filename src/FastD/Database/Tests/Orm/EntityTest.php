<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 16/2/26
 * Time: 下午6:50
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Database\Tests\Orm;

use Examples\Orm\Entity\Base;
use FastD\Database\Tests\Fixture_Database_TestCast;

class EntityTest extends Fixture_Database_TestCast
{
    const CONNECTION = [
        'database_host' => '127.0.0.1',
        'database_port' => '3306',
        'database_name' => 'dbunit',
        'database_user' => 'root',
        'database_pwd' => '123456'
    ];

    public function testFind()
    {
        $base = new Base(['name' => 'joe'], $this->createDriver());

        $this->assertEquals('joe', $base->getName());

        $this->assertEquals(1, $base->getId());
    }

    public function testSave()
    {
        $base = new Base(null, $this->createDriver());

        $base->setContent('hello janhuang');
        $base->setName('bbb');
        $base->setCreateAt(time());

        $this->assertEquals(3, $base->save());

        $base = new Base(['id' => 1], $this->createDriver());

        $base->setContent('hello janhuang');
        $base->setName('bbb');
        $base->setCreateAt(time());

        $this->assertEquals(1, $base->save());
    }
}