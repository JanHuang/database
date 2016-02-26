<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 16/2/25
 * Time: 下午6:20
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Database\Tests\Builder;

use FastD\Database\Builder\Field;
use FastD\Database\Builder\Key;
use FastD\Database\Builder\Table;

class TableTest extends \PHPUnit_Framework_TestCase
{
    public function testBase()
    {
        $table = new Table('demo', [
            new Field('name', 'varchar', 20)
        ]);

        $this->assertEquals($table->getTable(), 'demo');
    }

    public function testCreate()
    {
        $table = new Table('demo', [
            new Field('name', 'varchar', 20)
        ]);

        $this->assertEquals(<<<M
CREATE TABLE `demo` (
`name` varchar(20) NOT NULL DEFAULT ''
) ENGINE=InnoDB CHARSET=utf8;
M
            , $table->toSql());
    }

    public function testAdd()
    {
        $primary = new Field('id', 'int', 10);

        $primary->setKey(new Key());

        $primary->setPrimary();

        $table = new Table('demo', [
            $primary
        ]);

        $this->assertEquals([
            'ALTER TABLE `demo` ADD `id` int(10) NOT NULL DEFAULT 0;',
            'ALTER TABLE `demo` ADD PRIMARY KEY (`id`);'
        ], explode(PHP_EOL, $table->toSql(Table::TABLE_ADD)));
    }

    public function testChange()
    {
        $table = new Table('demo', [
            new Field('name', 'varchar', 20)
        ]);

        $table->addField('name', new Field('nickname', 'char', 255));

        $this->assertEquals(<<<M
ALTER TABLE `demo` CHANGE `name` `nickname` char(255) NOT NULL DEFAULT '';
M
            , $table->toSql(Table::TABLE_CHANGE));
    }

    public function testDrop()
    {
        $table = new Table('demo');

        $this->assertEquals($table->toSql(Table::TABLE_DROP), 'DROP TABLE `demo`;');
    }

    public function testKey()
    {
        $name = new Field('name', 'varchar', 20);
        $name->setKey(new Key());

        $age = new Field('age', 'smallint', 2);

        $table = new Table('demo', [$name, $age]);

        $this->assertEquals([
            'ALTER TABLE `demo` CHANGE `name` `name` varchar(20) NOT NULL DEFAULT \'\';',
            'ALTER TABLE `demo` CHANGE `age` `age` smallint(2) NOT NULL DEFAULT 0;',
            'ALTER TABLE `demo` ADD INDEX `index_name` (`name`);',
        ], explode(PHP_EOL, $table->toSql(Table::TABLE_CHANGE)));

        $this->assertEquals([
            'ALTER TABLE `demo` ADD `name` varchar(20) NOT NULL DEFAULT \'\';',
            'ALTER TABLE `demo` ADD `age` smallint(2) NOT NULL DEFAULT 0;',
            'ALTER TABLE `demo` ADD INDEX `index_name` (`name`);',
        ], explode(PHP_EOL, $table->toSql(Table::TABLE_ADD)));
    }
}
