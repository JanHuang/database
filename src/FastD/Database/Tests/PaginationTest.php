<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/6/20
 * Time: 上午9:53
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Database\Tests;

use FastD\Database\Driver\Driver;
use FastD\Database\Config;
use FastD\Database\Pagination\QueryPagination;

class PaginationTest extends \PHPUnit_Framework_TestCase
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

    public function testNullQueryContextAndDriverPagination()
    {
        $pagination = new QueryPagination(30);

        $this->assertEquals(2, $pagination->getTotalPages());
        $this->assertEquals(1, $pagination->getCurrentPage());
        $this->assertEquals(1, $pagination->getPrevPage());
        $this->assertEquals(2, $pagination->getNextPage());
        $this->assertEquals(2, $pagination->getTotalPages());
        $this->assertEquals(1, $pagination->getFirstPage());
        $this->assertEquals(2, $pagination->getLastPage());
        $this->assertEquals([1, 2], $pagination->getPageList());
        $this->assertNull($pagination->getResult());

        $pagination = new QueryPagination(51); // totolpage 3

        $this->assertEquals(51, $pagination->getTotalRows());
        $this->assertEquals(3, $pagination->getTotalPages());
        $this->assertEquals(1, $pagination->getCurrentPage());
        $this->assertEquals(1, $pagination->getPrevPage());
        $this->assertEquals(2, $pagination->getNextPage());
        $this->assertEquals(1, $pagination->getFirstPage());
        $this->assertEquals(3, $pagination->getLastPage());
        $this->assertEquals([1,2,3], $pagination->getPageList());
        $this->assertNull($pagination->getResult());
    }

    public function testDriverPagination()
    {
        // The `ws_user` table is has 8 rows.
        $pagination = $this->driver->pagination('ws_user', 1);

        $this->assertEquals(1, $pagination->getPrevPage());
        $this->assertEquals(1, $pagination->getFirstPage());
        $this->assertEquals(1, $pagination->getLastPage());
        $this->assertEquals(1, $pagination->getNextPage());
    }

    public function testDriverPaginationList()
    {
        // The `ws_user` table is has 8 rows.
        $pagination = $this->driver->pagination('ws_user', 2, 1);

        $this->assertEquals(8, $pagination->getTotalRows());
        $this->assertEquals(8, $pagination->getTotalPages());
        $this->assertEquals(8, $pagination->getLastPage());
        $this->assertEquals(2, $pagination->getCurrentPage());
        $this->assertEquals([1,2,3,4,5], $pagination->getPageList());

        $pagination = $this->driver->pagination('ws_user', 6, 1);
        $this->assertEquals(8, $pagination->getTotalRows());
        $this->assertEquals(8, $pagination->getTotalPages());
        $this->assertEquals(8, $pagination->getLastPage());
        $this->assertEquals(6, $pagination->getCurrentPage());
        $this->assertEquals([4,5,6,7,8], $pagination->getPageList());

        $pagination = $this->driver->pagination('ws_user', 4, 1);
        $this->assertEquals(8, $pagination->getTotalRows());
        $this->assertEquals(8, $pagination->getTotalPages());
        $this->assertEquals(8, $pagination->getLastPage());
        $this->assertEquals(4, $pagination->getCurrentPage());
        $this->assertEquals([2,3,4,5,6], $pagination->getPageList());

        $pagination = $this->driver->pagination('ws_user', 6, 1, 5, 6);
        $this->assertEquals(8, $pagination->getTotalRows());
        $this->assertEquals(8, $pagination->getTotalPages());
        $this->assertEquals(8, $pagination->getLastPage());
        $this->assertEquals(6, $pagination->getCurrentPage());
        $this->assertEquals([4,5,6,7,8], $pagination->getPageList());
        $pagination->getResult();
        $this->assertEquals('SELECT * FROM `ws_user` WHERE `id` > 6 LIMIT 1;', $pagination->getQueryString());

        $pagination = $this->driver->pagination('ws_user', 3, 2, 5, 6);
        $this->assertEquals(8, $pagination->getTotalRows());
        $this->assertEquals(4, $pagination->getTotalPages());
        $this->assertEquals(4, $pagination->getLastPage());
        $this->assertEquals(3, $pagination->getCurrentPage());
        $this->assertEquals([1,2,3,4], $pagination->getPageList());
        $pagination->getResult();
        $this->assertEquals('SELECT * FROM `ws_user` WHERE `id` > 6 LIMIT 2;', $pagination->getQueryString());

        $pagination = $this->driver->pagination('ws_user', 3, 2, 5);
        $this->assertEquals(8, $pagination->getTotalRows());
        $this->assertEquals(4, $pagination->getTotalPages());
        $this->assertEquals(4, $pagination->getLastPage());
        $this->assertEquals(3, $pagination->getCurrentPage());
        $this->assertEquals([1,2,3,4], $pagination->getPageList());
        $pagination->getResult();
        $this->assertEquals('SELECT * FROM `ws_user` LIMIT 4,2;', $pagination->getQueryString());

        $pagination = $this->driver->pagination('ws_user', 2, 2, 5);
        $this->assertEquals(8, $pagination->getTotalRows());
        $this->assertEquals(4, $pagination->getTotalPages());
        $this->assertEquals(4, $pagination->getLastPage());
        $this->assertEquals(2, $pagination->getCurrentPage());
        $this->assertEquals([1,2,3,4], $pagination->getPageList());
        $pagination->getResult();
        $this->assertEquals('SELECT * FROM `ws_user` LIMIT 2,2;', $pagination->getQueryString());
    }
}