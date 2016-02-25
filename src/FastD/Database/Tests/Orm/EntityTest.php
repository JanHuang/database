<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 16/2/19
 * Time: 上午12:19
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Database\Tests\Orm;

use FastD\Database\Tests\Fixture_Database_TestCast;
use FastD\Database\Tests\Orm\Entity\Dbunit;

class EntityTest extends Fixture_Database_TestCast
{
    const CONNECTION = [
        'host'      => '127.0.0.1',
        'port'      => '3306',
        'dbname'    => 'dbunit',
        'user'      => 'root',
        'pwd'       => '123456'
    ];

    public function testConstruct()
    {
        $dbunit = new Dbunit(null, $this->createDriver());

//        $this->assertEquals(3, $dbunit->save());
    }
}