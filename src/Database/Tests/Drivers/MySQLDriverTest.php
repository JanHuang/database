<?php
/**
 *
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2016
 *
 * @link      https://www.github.com/janhuang
 * @link      http://www.fast-d.cn/
 */

namespace Database\Tests\Drivers;

use FastD\Database\Drivers\MySQLDriver;
use FastD\Database\Tests\Fixture_Database_TestCast;

class MySQLDriverTest extends Fixture_Database_TestCast
{
    const CONNECTION = [
        'database_host'      => '127.0.0.1',
        'database_port'      => '3306',
        'database_name'      => 'dbunit',
        'database_user'      => 'root',
        'database_pwd'       => '1234563'
    ];

    public function testDriverConnection()
    {
        $driver = new MySQLDriver(self::CONNECTION);
    }
}
