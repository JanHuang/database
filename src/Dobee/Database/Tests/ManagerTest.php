<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/6/20
 * Time: 上午2:19
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace Dobee\Database\Tests;

use Dobee\Database\Database;
use Dobee\Database\Driver\Driver;
use Dobee\Database\Connection\ConnectionInterface;
use Dobee\Database\Query\QueryContext;

class ManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Database
     */
    private $manager;

    public function setUp()
    {
        $this->manager = new Database([
            'read' => [
                'database_type' => 'mysql',
                'database_user' => 'root',
                'database_pwd'  => '123456',
                'database_host' => '127.0.0.1',
                'database_port' => 3306,
                'database_name' => 'test',
            ],
            'write' => [
                'database_type' => 'mysql',
                'database_user' => 'root',
                'database_pwd'  => '123456',
                'database_host' => '127.0.0.1',
                'database_port' => 3306,
                'database_name' => 'test',
            ],
        ]);
    }

    public function testGetDriver()
    {
        $this->assertInstanceOf('Dobee\Database\Driver\Driver', $this->manager->getConnection('read'));
    }

    public function testGetConnection()
    {
        $this->assertInstanceOf('Dobee\Database\Connection\ConnectionInterface', $this->manager->getConnection('read')->getConnection());
        $this->assertInstanceOf('Dobee\Database\Query\QueryContext', $this->manager->getConnection('read')->getQueryContext());
        $this->assertTrue($this->manager->hasConnection('read'));
        $this->assertFalse($this->manager->hasConnection('write'));
    }
}