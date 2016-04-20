<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 16/4/19
 * Time: 下午7:18
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Database\Tests\Page;

use Examples\Orm\Dbunit\Repository\BaseRepository;
use Examples\Orm\Dbunit\Repository\Demo2Repository;
use FastD\Database\Query\Paging\Pagination;
use FastD\Database\Query\Paging\QueryPagination;
use FastD\Database\Tests\Fixture_Database_TestCast;

class PageTest extends Fixture_Database_TestCast
{
    const CONNECTION = [
        'database_host'      => '127.0.0.1',
        'database_port'      => '3306',
        'database_name'      => 'dbunit',
        'database_user'      => 'root',
        'database_pwd'       => '123456'
    ];

    public function testPage()
    {
        $page = new Pagination(10, 1, 4);

        $this->assertEquals(3, $page->getTotalPages());
        $this->assertEquals(1, $page->getCurrentPage());
        $this->assertEquals(10, $page->getTotalRows());
        $this->assertEquals(0, $page->getOffset());
        $this->assertEquals(4, $page->getShowList());
        $this->assertEquals(1, $page->getPrevPage());

        $page = new Pagination(100, 5);

        $this->assertEquals(4, $page->getTotalPages());
        $this->assertEquals(75, $page->getOffset());
        $this->assertEquals(4, $page->getNextPage());
        $this->assertEquals(3, $page->getPrevPage());

        $this->assertEquals($page->getPageList(), [1, 2, 3, 4]);

        $page = new Pagination(100, 5, 10);

        $this->assertEquals($page->getPageList(), [3, 4, 5, 6, 7]);

        $page = new Pagination(100, 10, 10);

        $this->assertEquals($page->getPageList(), [6, 7, 8, 9, 10]);

        $page = new Pagination(100, 1, 10);

        $this->assertEquals($page->getPageList(), [1, 2, 3, 4, 5]);

        $page = new Pagination(100, 2, 10);

        $this->assertEquals($page->getPageList(), [1, 2, 3, 4, 5]);
    }

    public function testQueryPage()
    {
        $repository = new BaseRepository($this->createDriver());

        $page = new QueryPagination($repository, 1);

        $this->assertEquals(2, $page->getTotalRows());

        $this->assertEquals(1, $page->getTotalPages());

        $page = new QueryPagination($repository, 1, 1);

        $this->assertEquals(2, $page->getTotalPages());

        $this->assertEquals(1, $page->getResult()[0]['id']);

        $page = new QueryPagination($repository, 1, 1);

        $this->assertEquals(1, $page->getResult()[0]['id']);
    }
}
