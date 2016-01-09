<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/12/16
 * Time: 下午3:16
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Database\Tests\Paging;

use FastD\Database\Drivers\MySQL;
use FastD\Database\Drivers\Query\Paging\Pagination;

class PaginationTest extends \PHPUnit_Framework_TestCase
{
    public function testInstance()
    {
        $pagination = new Pagination(100, 1);
        $this->assertEquals(4, $pagination->getTotalPages());
        $this->assertEquals($pagination->getNextPage(), 2);
    }

    public function testDriver()
    {
        $driver = new MySQL([
            'database_type' => 'mysql',
            'database_user' => 'root',
            'database_pwd'  => '123456',
            'database_host' => '127.0.0.1',
            'database_port' => 3306,
            'database_name' => 'test',
        ]);


        $driver->where(['id' => 1]);

        $pagination = new Pagination($driver->table('test'));

//        print_r($pagination);
//        $this->assertEquals(1, $pagination->getTotalRows());

        print_r($pagination->getResult());
        print_r($pagination);
    }
}
