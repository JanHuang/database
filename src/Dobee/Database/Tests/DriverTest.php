<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/6/18
 * Time: 下午11:35
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace Dobee\Database\Tests;

use Dobee\Database\Config;
use Dobee\Database\Driver\Driver;

class DriverTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Driver
     */
    private $driver;

    public function setUp()
    {
        $this->driver = new Driver(new Config([
            'database_type' => 'mysql',
            'database_user' => 'root',
            'database_pwd'  => '123456',
            'database_host' => '127.0.0.1',
            'database_port' => 3306,
            'database_name' => 'test',
        ]));
    }

    public function testInsert()
    {

    }

    public function testDelete()
    {
        // not delete operation. Because delete operation is very danger.
        // So. That nonsupport delete operation.
    }

    public function testUpdate()
    {
        // not update affected row.
        $this->assertEquals(0, $this->driver->update('ws_user', ['username' => 'janhuang']));

        $this->assertEquals('UPDATE `ws_user` SET `username`=\'janhuang\';', $this->driver->getSql());

        // Try update one row. But not update affected row.
        $this->assertEquals(0, $this->driver->limit(1)->update('ws_user', ['username' => 'janhuang']));

        $this->assertEquals('UPDATE `ws_user` SET `username`=\'janhuang\' LIMIT 1;', $this->driver->getSql());
    }
}