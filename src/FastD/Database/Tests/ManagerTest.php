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

namespace FastD\Database\Tests;

use FastD\Database\Database;
use FastD\Database\Driver\Driver;
use FastD\Database\Connection\ConnectionInterface;
use FastD\Database\Query\QueryContext;

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
        $this->assertInstanceOf('FastD\Database\Driver\Driver', $this->manager->getConnection('read'));
    }

    public function testGetConnection()
    {
        $this->assertInstanceOf('FastD\Database\Connection\ConnectionInterface', $this->manager->getConnection('read')->getConnection());
        $this->assertInstanceOf('FastD\Database\Query\QueryContext', $this->manager->getConnection('read')->getQueryContext());
        $this->assertTrue($this->manager->hasConnection('read'));
        $this->assertFalse($this->manager->hasConnection('write'));
    }
}