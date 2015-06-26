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

    public function testPagination()
    {
        $pagination = $this->driver->pagination('ws_user', 1);
        $this->assertEquals(1, $pagination->getPrevPage());
        $this->assertEquals(1, $pagination->getFirstPage());
        $this->assertEquals(2, $pagination->getLastPage());
        $this->assertEquals(2, $pagination->getNextPage());
    }

    public function testPaginationList()
    {
        $pagination = $this->driver->pagination('ws_user', 2);

        $pagination->setTotal(11)->initialize();

        $this->assertEquals([1, 2, 3], $pagination->getPageList());

        $pagination->setTotal(21)->initialize(); // 21 / 5 5

        $this->assertEquals([1,2,3,4,5], $pagination->getPageList());

        $pagination->setTotal(31)->setPage(2)->initialize(); // 31 / 5 = 7

        $this->assertEquals([1,2,3,4,5], $pagination->getPageList());

        $pagination->setTotal(31)->setPage(4)->initialize(); // 31 / 5 = 7

        $this->assertEquals([2,3,4,5,6], $pagination->getPageList());

        $pagination->setTotal(31)->setPage(5)->initialize(); // 31 / 5 = 7

        $this->assertEquals([3,4,5,6,7], $pagination->getPageList());

        $pagination->setTotal(31)->setPage(7)->initialize(); // 31 / 5 = 7

        $this->assertEquals([3,4,5,6,7], $pagination->getPageList());
    }

    public function testPaginationResult()
    {
        $pagination = $this->driver->where(['username' => 'janhuang'])->pagination('ws_user', 1, 1, 1);

        $pagination->getResult();
    }
}