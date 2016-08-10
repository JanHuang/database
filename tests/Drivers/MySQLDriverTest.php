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
use FastD\Database\Query\QueryBuilder;
use Tests\Fixture_Database_TestCast;

class MySQLDriverTest extends Fixture_Database_TestCast
{
    public function testDriverConnection()
    {
        $driver = new MySQLDriver(static::CONNECTION);

        $result = $driver->query('select * from base;')->execute()->getAll();

        $this->assertEquals(2, count($result));

        try {
            $driver->transaction(function (DriverInterface $driver) {
                $driver->query('delete from base where id = 1')->execute()->getAffected();
            });

            $result = $driver->query('select * from base;')->execute()->getAll();

            $this->assertEquals(1, count($result));
        } catch (Exception $e) {
        }

        try {
            $driver->transaction(function (DriverInterface $driver) {
                $driver->query('delete from base where id = 1')->execute()->getAffected();
                throw new Exception('rollback');
            });
        } catch (Exception $e) {
            $result = $driver->query('select * from base;')->execute()->getAll();
            $this->assertEquals(1, count($result));
            $this->assertEquals('rollback', $e->getMessage());
        }
    }
}
