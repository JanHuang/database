<?php
/**
 *
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2016
 *
 * @link      https://www.github.com/janhuang
 * @link      http://www.fast-d.cn/
 */

namespace Database\Tests\Query;

use FastD\Database\Query\MySQLQueryBuilder;

class MySQLQueryBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testFields()
    {
        $queryBuilder = new MySQLQueryBuilder();
        
        $this->assertEquals($queryBuilder->from('test'), 'SELECT * FROM `test`;');

        $this->assertEquals($queryBuilder->select(['name'])->from('test'), 'SELECT `name` FROM `test`;');
    }
}
