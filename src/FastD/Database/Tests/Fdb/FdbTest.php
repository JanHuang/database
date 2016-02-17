<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 16/2/17
 * Time: 下午11:19
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Database\Tests\Fdb;

use FastD\Database\Fdb;
use FastD\Database\Tests\Fixture_Database_TestCast;

class FdbTest extends Fixture_Database_TestCast
{
    const CONNECTION = [
        'host'      => '127.0.0.1',
        'port'      => '3306',
        'dbname'    => 'dbunit',
        'user'      => 'root',
        'pwd'       => '123456'
    ];

    public function testIterator()
    {
        $fdb = new Fdb([
            "read" => [
                'host'      => '127.0.0.1',
                'port'      => '3306',
                'dbname'    => 'dbunit',
                'user'      => 'root',
                'pwd'       => '123456'
            ],
            "write" => [
                'host'      => '127.0.0.1',
                'port'      => '3306',
                'dbname'    => 'dbunit',
                'user'      => 'root',
                'pwd'       => '123456'
            ],
        ]);

        $fdb->createPool();

        foreach ($fdb as $key => $value) {
            var_dump($key);
        }
    }
}
