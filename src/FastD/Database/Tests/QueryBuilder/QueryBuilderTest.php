<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 16/2/18
 * Time: 下午4:23
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Database\Tests\QueryBuilder;

use FastD\Database\Query\Mysql;
use FastD\Database\Query\QueryBuilder;

class QueryBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var QueryBuilder
     */
    protected $builder;

    public function setUp()
    {
        $this->builder = new Mysql();
    }

    public function testTable()
    {
        $this->assertEquals('SELECT * FROM `base`;', $this
            ->builder
            ->table('base')
            ->select());

        $this->assertEquals('SELECT * FROM `base` AS `b`;', $this
            ->builder
            ->table('base', 'b')
            ->select());
    }

    public function testFields()
    {
        $this->assertEquals('SELECT `name` FROM `base` AS `b`;', $this
            ->builder
            ->fields(['name'])
            ->table('base', 'b')
            ->select());

        $this->assertEquals('SELECT `name` AS `true_name` FROM `base` AS `b`;', $this
            ->builder
            ->fields(['name' => 'true_name'])
            ->table('base', 'b')
            ->select());

        $this->assertEquals('SELECT `name` AS `true_name`,`nickname` AS `nick_name` FROM `base` AS `b`;', $this
            ->builder
            ->fields([
                'name' => 'true_name',
                'nickname' => 'nick_name'
            ])
            ->table('base', 'b')
            ->select());

        // select count(1),`nickname` AS `nick_name` FROM `base` AS `b`;
        $this->assertEquals('SELECT `nickname` AS `nick_name` FROM `base` AS `b`;', $this
            ->builder
            ->fields([
                'nickname' => 'nick_name'
            ])
            ->table('base', 'b')
            ->select());
    }

    public function testWhere()
    {
        $this->assertEquals('SELECT * FROM `base` WHERE `id`=\'1\';', $this
            ->builder
            ->table('base')
            ->where(['id' => 1])
            ->select());

        $this->assertEquals('SELECT * FROM `base` WHERE `id`=\'1\' and `name`=\'jan\';', $this
            ->builder
            ->table('base')
            ->where([
                'and' => [
                    'id' => 1,
                    'name' => 'jan'
                ]
            ])
            ->select());

        $this->assertEquals('SELECT * FROM `base` WHERE `id`=\'1\' or `name`=\'jan\';', $this
            ->builder
            ->table('base')
            ->where([
                'or' => [
                    'id' => 1,
                    'name' => 'jan'
                ]
            ])
            ->select());

        $this->assertEquals('SELECT * FROM `base` WHERE `id`>\'10\';', $this
            ->builder
            ->table('base')
            ->where([
                '[>]id' => 10
            ])
            ->select());

        $this->assertEquals('SELECT * FROM `base` WHERE `id`>\'10\' or `age`>\'20\';', $this
            ->builder
            ->table('base')
            ->where([
                'or' => [
                    '[>]id' => 10,
                    '[>]age' => 20,
                ]
            ])
            ->select());
    }

    public function testData()
    {
        $this->assertEquals('INSERT INTO `base`(`name`) VALUES (\'jan\');', $this
            ->builder
            ->table('base')
            ->insert(['name' => 'jan']));

        $this->assertEquals('UPDATE `base` SET `name`=\'jan\';', $this
            ->builder
            ->table('base')
            ->update(['name' => 'jan']));

        $this->assertEquals('UPDATE `base` SET `name`=\'jan\' WHERE `id`=\'1\';', $this
            ->builder
            ->table('base')
            ->update(['name' => 'jan'], ['id' => 1]));
    }

    public function testLimit()
    {
        $this->assertEquals('UPDATE `base` SET `name`=\'jan\' WHERE `id`=\'1\' LIMIT 1;', $this
            ->builder
            ->table('base')
            ->limit(1)
            ->update(['name' => 'jan'], ['id' => 1]));

        $this->assertEquals('SELECT * FROM `base` LIMIT 1;', $this
            ->builder
            ->table('base')
            ->limit(1)
            ->select()
        );

        $this->assertEquals('SELECT * FROM `base` LIMIT 5,1;', $this
            ->builder
            ->table('base')
            ->limit(1, 5)
            ->select()
        );
    }

    public function testGroupBy()
    {
        $this->assertEquals('SELECT * FROM `base` GROUP BY `name`;', $this
            ->builder
            ->table('base')
            ->groupBy(['name'])
            ->select()
        );

        $this->assertEquals('SELECT * FROM `base` GROUP BY `name`,`age`;', $this
            ->builder
            ->table('base')
            ->groupBy(['name', 'age'])
            ->select()
        );
    }

    public function testOrderBy()
    {
        $this->assertEquals('SELECT * FROM `base` ORDER BY `name` DESC,`age` DESC;', $this
            ->builder
            ->table('base')
            ->orderBy([
                'name' => 'DESC',
                'age' => 'DESC'
            ])
            ->select()
        );

        $this->assertEquals('SELECT * FROM `base` ORDER BY `name` DESC,`age` ASC;', $this
            ->builder
            ->table('base')
            ->orderBy([
                'name' => 'DESC',
                'age' => 'ASC'
            ])
            ->select()
        );
    }

    public function testLike()
    {
        $this->assertEquals('SELECT * FROM `base` WHERE `name` LIKE \'%jan%\';', $this
            ->builder
            ->table('base')
            ->like([
                'name' => '%jan%'
            ])
            ->select()
        );

        $this->assertEquals('SELECT * FROM `base` WHERE `name` NOT LIKE \'%jan%\';', $this
            ->builder
            ->table('base')
            ->notLike([
                'name' => '%jan%'
            ])
            ->select()
        );
    }

    public function testHaving()
    {
        $this->assertEquals('SELECT * FROM `base` HAVING `age`>\'10\';', $this
            ->builder
            ->table('base')
            ->having(['[>]age' => 10])
            ->select());
    }
}