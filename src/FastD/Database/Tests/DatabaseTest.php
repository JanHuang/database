<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/12/12
 * Time: 下午7:58
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Database\Tests;

use FastD\Database\Database;
use FastD\Database\Connection\Connection;
use FastD\Database\Connection\ConnectionInterface;

class DatabaseTest extends \PHPUnit_Framework_TestCase
{
    public function testMultiConfiguration()
    {
        $config = [
            'test' => [
                'database_type' => 'mysql',
                'database_user' => 'root',
                'database_pwd'  => '123456',
                'database_host' => '127.0.0.1',
                'database_port' => 3306,
                'database_name' => 'test',
            ],
            'demo' => [
                'database_type' => 'mysql',
                'database_user' => 'root',
                'database_pwd'  => '123456',
                'database_host' => '127.0.0.1',
                'database_port' => 3306,
                'database_name' => 'test',
            ],
        ];

        $db = new Database($config);

        $testConnection = $db->getConnection('test');
        $demoConnection = $db->getConnection('demo');

        $this->assertInstanceOf(Connection::class, $testConnection);
        $this->assertInstanceOf(Connection::class, $demoConnection);

        $this->assertTrue($testConnection instanceof $demoConnection);
        $this->assertTrue($testConnection->getName() != $demoConnection->getName());
        $this->assertInstanceOf(\PDO::class, $testConnection->getPDO());

        foreach ($db as $connectionInterface) {
            $this->assertInstanceOf(Connection::class, $connectionInterface);
            $this->assertInstanceOf(ConnectionInterface::class, $connectionInterface);
        }
    }
}
