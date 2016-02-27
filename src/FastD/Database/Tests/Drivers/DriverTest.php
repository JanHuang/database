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

use FastD\Database\Driver;
use FastD\Database\ORM\Repository;
use FastD\Database\Tests\Fixture_Database_TestCast;

/**
 * Class DriverTest
 *
 * @package FastD\Database\Tests
 */
class DriverTest extends Fixture_Database_TestCast
{
    const CONNECTION = [
        'database_host' => '127.0.0.1',
        'database_port' => '3306',
        'database_name' => 'dbunit',
        'database_user' => 'root',
        'database_pwd' => '123456'
    ];

    const NAME = 'dbunit';

    /**
     * @var Driver
     */
    protected $driver;

    public function setUp()
    {
        $this->driver = $this->createDriver();
    }

    /**
     * id: 1
     * content: "Hello buddy!"
     * name: "joe"
     * create_at: 2010-04-24 17:15:23
     * -
     * id: 2
     * content: "I like it!"
     * name: "janhuang"
     * create_at: 2010-04-26 12:14:20
     */
    public function testDriverQuery()
    {
        $rows = $this->driver->query('select * from base')->execute()->getAll();

        $this->assertNotEmpty($rows);

        $this->assertNotFalse($rows);

        $rows = $this->driver->query('select * from base2')->execute()->getAll();

        $this->assertEmpty($rows);

        $error = $this->driver->getError();

        $this->assertEquals('1146', $error->getCode());

        $row = $this->driver->query('select * from base where id = 1')->execute()->getOne();

        $this->assertEquals('joe', $row['name']);

        /*$this->assertEquals([
            [
                'id' => '1',
                'content' => 'Hello buddy!',
                'name' => 'joe',
                'create_at' => '2010-04-24 17:15:23'
            ],
            [
                'id' => '2',
                'content' => 'I like it!',
                'name' => 'janhuang',
                'create_at' => '2010-04-26 12:14:20'
            ],

        ], $rows);*/
    }

    public function testDriverParameters()
    {
        $parameters = $this
            ->driver
            ->setParameter([
                'name' => 'janhuang'
            ])
            ->getParameters()
            ;

        $this->assertEquals([':name' => 'janhuang'], $parameters);

        $parameters = $this
            ->driver
            ->setParameter([
                'name' => 'janhuang',
                'age' => '18'
            ])
            ->getParameters()
            ;

        $this->assertEquals([':name' => 'janhuang', ':age' => '18'], $parameters);


    }

    public function testDriverBindParameters()
    {
        $row = $this
            ->driver
            ->query('select * from base where id = :id')
            ->setParameter([
                'id' => 1
            ])
            ->execute()
            ->getOne()
        ;

        $this->assertEquals('joe', $row['name']);

        $row = $this
            ->driver
            ->query('select * from base where id = :id')
            ->setParameter([
                'id' => 1
            ])
            ->execute()
            ->getAll()
        ;

        $this->assertEquals('joe', $row[0]['name']);

        $id = $this
            ->driver
            ->query('insert into base (name) values(:name)')
            ->setParameter([
                'name' => 'ken'
            ])
            ->execute()
            ->getId()
            ;

        $this->assertNotEmpty($id);

        $this->assertEquals(3, $id);

        $affected = $this
            ->driver
            ->query('update base set name = :name where id = :id')
            ->setParameter([
                'name' => 'Dr\' Huang',
                'id' => 1
            ])
            ->execute()
            ->getAffected();

        $this->assertNotEmpty($affected);

        $this->assertEquals(1, $affected);
    }
}
