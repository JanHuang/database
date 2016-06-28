<?php
/**
 *
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2016
 *
 * @link      https://www.github.com/janhuang
 * @link      http://www.fast-d.cn/
 */

namespace Database\Tests\Pagination;

use FastD\Database\ORM\Model;
use FastD\Database\Pagination\Pagination;
use FastD\Database\Tests\Fixture_Database_TestCast;

class DemoModel extends Model
{
    const TABLE = 'base';
}

class PaginationTest extends Fixture_Database_TestCast
{
    public function testPagination()
    {
        $pagination = new Pagination(new DemoModel($this->getLocalDriver()), 1, 1);

        $this->assertEquals(2, $pagination->getTotalPages());

        $this->assertEquals('joe', $pagination->getResult()[0]['name']);
    }

    public function testPaginationInModel()
    {
        $model = new DemoModel($this->getLocalDriver());

        $pagination = $model->pagination(1, 1);

        $this->assertEquals(2, $pagination->getTotalPages());

        $this->assertEquals('joe', $pagination->getResult()[0]['name']);
    }
}
