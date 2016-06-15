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
        'database_host'      => '127.0.0.1',
        'database_port'      => '3306',
        'database_name'      => 'dbunit',
        'database_user'      => 'root',
        'database_pwd'       => '123456'
    ];

    const NAME = 'dbunit';

    public function testDriver()
    {
        $fdb = new Fdb([
            "read" => [
                'database_host'      => '127.0.0.1',
                'database_port'      => '3306',
                'database_name'      => 'dbunit',
                'database_user'      => 'root',
                'database_pwd'       => '123456'
            ],
            "write" => [
                'database_host'      => '127.0.0.1',
                'database_port'      => '3306',
                'database_name'      => 'dbunit',
                'database_user'      => 'root',
                'database_pwd'       => '123456'
            ],
        ]);

        $this->assertInstanceOf('FastD\Database\DriverInterface', $fdb->getDriver('read'));

        $this->assertInstanceOf('\PDO', $fdb->getDriver('read')->getPdo());

        $this->assertEquals(1, $fdb->count());

        $fdb->createPool();

        $this->assertEquals(2, $fdb->count());
    }

    public function testIterator()
    {
        $fdb = new Fdb([
            "read" => [
                'database_host'      => '127.0.0.1',
                'database_port'      => '3306',
                'database_name'      => 'dbunit',
                'database_user'      => 'root',
                'database_pwd'       => '123456'
            ],
            "write" => [
                'database_host'      => '127.0.0.1',
                'database_port'      => '3306',
                'database_name'      => 'dbunit',
                'database_user'      => 'root',
                'database_pwd'       => '123456'
            ],
        ]);

        $fdb->createPool();

        $keys = [];

        foreach ($fdb as $key => $value) {
            $keys[] = $key;
        }

        $this->assertEquals(['read', 'write'], $keys);
    }
}
