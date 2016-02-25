<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 16/2/25
 * Time: 下午5:53
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Database\Tests\Builder;

use FastD\Database\Builder\Field;

class FieldTest extends \PHPUnit_Framework_TestCase
{
    public function testBase()
    {
        $name = new Field('name', 'varchar');

        $this->assertEquals('name', $name->getName());

        $this->assertEquals('varchar', $name->getType());

        $name = new Field('name', 'array', 20, 'true_name');

        $this->assertEquals('name', $name->getName());

        $this->assertEquals('varchar', $name->getType());

        $this->assertEquals('true_name', $name->getAlias());

        $this->assertEquals(20, $name->getLength());
    }

    public function testCreateSql()
    {
        $name = new Field('name', 'varchar', 20);

        $this->assertEquals('`name` varchar(20) NOT NULL', $name->toSql());

        $name = new Field('name', 'varchar', 20, '', true);

        $this->assertEquals('`name` varchar(20)', $name->toSql());

        $name = new Field('name', 'varchar', 20, '', true, 'janhuang', '姓名');

        $this->assertEquals('`name` varchar(20) COMMENT \'姓名\'', $name->toSql());

        $name = new Field('name', 'varchar', 20, '', false, 'janhuang', '姓名');

        $this->assertEquals('`name` varchar(20) NOT NULL DEFAULT \'janhuang\' COMMENT \'姓名\'', $name->toSql());
    }

    public function testChangeSql()
    {
        $name = new Field('name', 'varchar', 20);

        $name->changeTo(new Field('name2', 'char', 30));

        $this->assertEquals('CHANGE `name` `name2` char(30) NOT NULL', $name->toSql(Field::FIELD_CHANGE));
    }

    public function testSql()
    {
        $name = new Field('name', 'varchar', 20);

        $this->assertEquals('ADD `name` varchar(20) NOT NULL', $name->toSql(Field::FIELD_ADD));

        $this->assertEquals('CHANGE `name` `name` varchar(20) NOT NULL', $name->toSql(Field::FIELD_CHANGE));

        $this->assertEquals('DROP `name`', $name->toSql(Field::FIELD_DROP));
    }
}
