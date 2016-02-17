<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 16/2/17
 * Time: 下午11:03
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Database\Tests\Drivers;

use FastD\Database\Tests\Fixture_Database_TestCast;

/**
 * Class DriverTest
 *
 * @package FastD\Database\Tests
 */
class DriverTest extends Fixture_Database_TestCast
{
    /**
     *
     */
    const CONNECTION = [
        'host'      => '127.0.0.1',
        'port'      => '3306',
        'dbname'    => 'dbunit',
        'user'      => 'root',
        'pwd'       => '123456'
    ];

    /**
     * Testing usage..
     *
     * new Driver(\PDO());
     */
    public function testUsage()
    {
        echo "hello world";
    }
}
