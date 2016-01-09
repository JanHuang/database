<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/12/13
 * Time: 下午10:16
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Database\Tests\QueryContext;

use FastD\Database\Drivers\Query\MySQLQueryBuilder;

/**
 * Class MySQLQueryContextTest
 *
 * @package FastD\Database\Tests\QueryContext
 */
class MySQLQueryBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MySQLQueryBuilder
     */
    protected $queryContext;

    public function setUp()
    {
        $this->queryContext = new MySQLQueryBuilder();
    }

    public function testTable()
    {
        $this->queryContext->table('test')->select();

        $this->assertEquals(
            'SELECT * FROM `test`;',
            $this->queryContext->table('test')->getSql()
        );
    }

    public function testWhere()
    {
        $this->queryContext->table('test')->where(['a' => 'b'])->select();

        $this->assertEquals(
            'SELECT * FROM `test` WHERE `a`=\'b\';',
            $this->queryContext->getSql()
        );

        $this->queryContext->table('test')->where(
            [
                'AND' => [
                    'a' => 'b',
                    'b' => 'c'
                ]
            ]
        )->select();

        $this->assertEquals(
            'SELECT * FROM `test` WHERE `a`=\'b\' AND `b`=\'c\';',
            $this->queryContext->getSql()
        );

        $this->queryContext->table('test')->where(
            [
                'AND' => [
                    'a' => 'b',
                ]
            ]
        )->select();

        $this->assertEquals(
            'SELECT * FROM `test` WHERE `a`=\'b\';',
            $this->queryContext->getSql()
        );
    }

    public function testFields()
    {
        $this->queryContext
            ->fields([
                'id',
                'name' => 'nickname'
            ])
            ->table('test')
            ->select()
        ;

        $this->assertEquals(
            'SELECT `id`,`name` AS `nickname` FROM `test`;',
            $this->queryContext->getSql()
        );
    }

    public function testGroupBy()
    {
        $this->queryContext
            ->table('test')
            ->groupBy(['id'])
            ->select()
        ;

        $this->assertEquals(
            'SELECT * FROM `test` GROUP BY `id`;',
            $this->queryContext->getSql()
        );
    }

    public function testOrderBy()
    {
        $this->queryContext
            ->table('test')
            ->orderBy(['id' => 'DESC'])
            ->select()
        ;

        $this->assertEquals(
            'SELECT * FROM `test` ORDER BY `id` DESC;',
            $this->queryContext->getSql()
        );

        $this->queryContext
            ->table('test')
            ->orderBy([
                'id' => 'DESC',
                'name desc',
                'nickname' => 'ASC'
            ])
            ->select()
        ;

        $this->assertEquals(
            'SELECT * FROM `test` ORDER BY `id` DESC,name desc,`nickname` ASC;',
            $this->queryContext->getSql()
        );
    }

    public function testHaving()
    {
        $this->queryContext
            ->table('test')
            ->groupBy(
                [
                    'name',
                ]
            )
            ->having([
                'id[>]' => '20'
            ])
            ->select()
        ;

        $this->assertEquals(
            'SELECT * FROM `test` GROUP BY `name` HAVING `id`>\'20\';',
            $this->queryContext->getSql()
        );
    }

    public function testLike()
    {
        $this->queryContext
            ->table('test')
            ->like([
                'name' => '%name%'
            ])
            ->select()
        ;

        $this->assertEquals(
            'SELECT * FROM `test` WHERE `name` LIKE \'%name%\';',
            $this->queryContext->getSql()
        );
    }

    public function testUpdate()
    {
        $this->queryContext
            ->table('test')
            ->update([
                'name' => ':janhuang'
            ])
        ;

//        echo $this->queryContext->getSql();
    }

    public function testInsert()
    {
        $this->queryContext
            ->table('test')
            ->insert([
                'name' => ':janhuang'
            ])
        ;

//        echo $this->queryContext->getSql() . PHP_EOL;


        $this->queryContext
            ->table('test')
            ->insert([
                'name' => 'janhuang'
            ])
        ;

//        echo $this->queryContext->getSql() . PHP_EOL;

        $this->queryContext
            ->table('test')
            ->insert([
                'name' => 'janhuang',
                'age' => ':age',
                'gender' => 1
            ])
        ;

//        echo $this->queryContext->getSql() . PHP_EOL;
    }
}
