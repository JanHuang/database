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
use Tests\Fixture_Database_TestCast;

class MySQLDriverTest extends Fixture_Database_TestCast
{
    public function testDriverConnection()
    {
        $driver = new MySQLDriver(self::CONNECTION);
    }
}
