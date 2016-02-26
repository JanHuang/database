<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 16/2/26
 * Time: 上午11:44
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Database\Tests\Builder;

use FastD\Database\Builder\AutoBuilding;
use FastD\Database\Tests\Fixture_Database_TestCast;

class AutoBuildingTest extends Fixture_Database_TestCast
{
    const CONNECTION = [
        'host'      => '127.0.0.1',
        'port'      => '3306',
        'dbname'    => 'dbunit',
        'user'      => 'root',
        'pwd'       => '123456'
    ];

    /**
     * $builder->saveTo();
     */
    public function testMapping()
    {
        $driver = $this->createDriver();

        $auto = new AutoBuilding($driver);

        $auto->saveTo(__DIR__ . '/Orm', 'FastD\Database\Tests\Builder\\Orm', true);
    }
}