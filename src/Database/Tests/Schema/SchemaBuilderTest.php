<?php
/**
 *
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2016
 *
 * @link      https://www.github.com/janhuang
 * @link      http://www.fast-d.cn/
 */


namespace FastD\Database\Tests\Schema;

use FastD\Database\Schema\SchemaBuilder;
use FastD\Database\Schema\Structure\Field;
use FastD\Database\Schema\Structure\Key;
use FastD\Database\Schema\Structure\Table;

/**
 * Class SchemaBuilderTest
 * @package FastD\Database\Tests\Schema
 */
class SchemaBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testTableCreateSchema()
    {
        $testTable = new Table('test', '测试');

        $id = new Field('id', Field::INT, 11, false, '', '主键id');
        $id->setKey(new Key(Key::PRIMARY));
        $id->setIncrement(1);

        $testTable->addField($id);
        $testTable->addField(new Field('name', Field::VARCHAR, 10));

        $schemaBuilder = new SchemaBuilder([$testTable]);

        $this->assertEquals([$testTable->getFullTableName()], $schemaBuilder->getKeys());
    }

    public function testTableCreateKeySchema()
    {
        $builder = new SchemaBuilder();

        $testTable = new Table('test', '测试');

        $id = new Field('id', Field::INT, 11, false, '', '主键id');
        $id->setKey(new Key(Key::PRIMARY));
        $id->setIncrement(1);

        $testTable->addField($id);
        $testTable->addField(new Field('name', Field::VARCHAR, 10));

        $builder->addTable($testTable);

        $this->assertEquals(<<<EOF
CREATE TABLE `test` (
`id` int(11)  NOT NULL DEFAULT "0" AUTO_INCREMENT COMMENT "主键id",
`name` varchar(10)  NOT NULL DEFAULT ""  COMMENT "",
PRIMARY KEY (`id`)
) ENGINE InnoDB CHARSET utf8 COMMENT "测试";
EOF
            , $builder->table($testTable->getFullTableName())->create()
        );

        $testTable = new Table('test', '测试');

        $id = new Field('id', Field::INT, 11, false, '', '主键id');
        $id->setKey(new Key(Key::PRIMARY));

        $testTable->addField($id);
        $testTable->addField(new Field('name', Field::VARCHAR, 10));
        $builder->addTable($testTable);

        $this->assertEquals(<<<EOF
CREATE TABLE `test` (
`id` int(11)  NOT NULL DEFAULT "0"  COMMENT "主键id",
`name` varchar(10)  NOT NULL DEFAULT ""  COMMENT "",
PRIMARY KEY (`id`)
) ENGINE InnoDB CHARSET utf8 COMMENT "测试";
EOF
            , $builder->table($testTable->getFullTableName())->create()
        );

        $id = new Field('id', Field::INT, 11, false, '', '主键id');
        $id->setKey(new Key(Key::PRIMARY));
        $name = new Field('name', Field::VARCHAR, 10);
        $name->setKey(new Key(Key::INDEX));
        $code = new Field('code', Field::CHAR, 18);
        $code->setKey(new Key(Key::UNIQUE));

        $testTable->addField($id);
        $testTable->addField($name);
        $testTable->addField($code);
        $builder->addTable($testTable);

        $this->assertEquals(<<<EOF
CREATE TABLE `test` (
`id` int(11)  NOT NULL DEFAULT "0"  COMMENT "主键id",
`name` varchar(10)  NOT NULL DEFAULT ""  COMMENT "",
`code` char(18)  NOT NULL DEFAULT ""  COMMENT "",
PRIMARY KEY (`id`),
KEY `index_name` (`name`),
UNIQUE KEY `unique_code` (`code`)
) ENGINE InnoDB CHARSET utf8 COMMENT "测试";
EOF
            , $builder->table($testTable->getFullTableName())->create()
        );
    }

    public function testTableAlterSchema()
    {
        $builder = new SchemaBuilder();

        $testTable = new Table('test');

        $builder->addTable($testTable);

        $testTable->addField(new Field('nickname', Field::VARCHAR, 11), new Key(Key::INDEX));

        $this->assertEquals('', $builder->table($testTable->getFullTableName())->update());

        $testTable = new Table('test');

        $builder->addTable($testTable);

        $testTable->addField(new Field('name', Field::VARCHAR, 11), new Key(Key::INDEX));
        // Cache success
        $this->assertEquals(array_keys($builder->table($testTable->getFullTableName())->getCache()), ['id', 'name', 'code', 'nickname']);
    }

    public function testTableDropSchema()
    {
        $builder = new SchemaBuilder();

        $demoTable = new Table('demo');

        $builder->addTable($demoTable);

        $this->assertEquals($builder->table($demoTable->getFullTableName())->drop(), <<<EOF
DROP TABLE `demo`;
EOF
);

        $this->assertEquals($builder->table($demoTable->getFullTableName(), true)->drop(), <<<EOF
DROP TABLE IF EXISTS `demo`;
EOF
);
    }

    public function testMultiTableSchema()
    {
        $builder = new SchemaBuilder();

        $demoTable = new Table('demo');
        $builder->addTable($demoTable);

        $demoTable->addField(new Field('id', Field::INT, 10));

        $builder->table($demoTable->getFullTableName())->create();
    }
}
