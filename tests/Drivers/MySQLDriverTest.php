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

use Exception;
use FastD\Database\Drivers\DriverInterface;
use FastD\Database\Drivers\MySQLDriver;
use Tests\Fixture_Database_TestCast;

class MySQLDriverTest extends Fixture_Database_TestCast
{
    public function testDriverConnection()
    {
        $driver = new MySQLDriver([
            'database_host'      => '127.0.0.1',
            'database_port'      => '3306',
            'database_name'      => 'test',
            'database_user'      => 'root',
            'database_pwd'       => '123456'
        ]);

        try {
            $result = $driver->transaction(function (DriverInterface $driver) {
                $driver->query('drop table test;')->execute();
                throw new Exception('test');
            });
            var_dump($result);
        } catch (Exception $e) {
            echo 'rollback';
        }

        //
    }
}
