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
use FastD\Database\Builder\Table;
use FastD\Database\Tests\Fixture_Database_TestCast;

class AutoBuildingTest extends Fixture_Database_TestCast
{
    const CONNECTION = [
        'host' => '127.0.0.1',
        'port' => '3306',
        'dbname' => 'dbunit',
        'user' => 'root',
        'pwd' => '123456',
        'prefix' => 'fd_',
        'suffix' => '_fd2',
    ];

    /**
     * $builder->saveTo();
     */
    public function testMapping()
    {
        $driver = $this->createDriver();

        $auto = new AutoBuilding($driver);

        $auto->saveTo(__DIR__ . '/Orm', 'FastD\Database\Tests\Builder\Orm', true);
    }

    public function testYmlSaveTo()
    {
        $root = __DIR__ . '/../../../../../examples';

        $auto = new AutoBuilding(null, $root . '/yml');

        $auto->saveYmlTo($root . '/Orm', true);

        $auto->saveTo($root . '/Orm', 'Examples\Orm', true);
    }

    public function testYmlToTable()
    {
        $driver = $this->createDriver();

        $root = __DIR__ . '/../../../../../examples';

        $auto = new AutoBuilding($driver, $root . '/yml');

        $auto->ymlToTable($root . '/Orm', 'Examples\Orm', true, Table::TABLE_CREATE);
    }

    public function testTableToYml()
    {
        $driver = $this->createDriver();

        $root = __DIR__ . '/../../../../../examples';

        $auto = new AutoBuilding($driver, $root . '/yml');

        $auto->tableToYml($root . '/Orm', 'Examples\Orm', true);
    }
}