<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 16/2/25
 * Time: 下午10:13
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Database\Tests\Builder\Parser;

use FastD\Database\Builder\Parser;
use FastD\Database\Tests\Fixture_Database_TestCast;

class TableParserTest extends Fixture_Database_TestCast
{
    const CONNECTION = [
        'host'      => '127.0.0.1',
        'port'      => '3306',
        'dbname'    => 'dbunit',
        'user'      => 'root',
        'pwd'       => '123456'
    ];

    public function testTable()
    {
        $driver = $this->createDriver();

        $parser = new Parser($driver);

        $table = $parser->getTableByDb('demo');

//        echo PHP_EOL;

//        echo $table->toSql();

        $table = $parser->getTableByDb('base');

//        echo PHP_EOL;

//        echo $table->toSql();
    }
}
