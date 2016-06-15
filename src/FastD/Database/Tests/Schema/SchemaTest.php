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

use FastD\Database\Schema\Schema;
use FastD\Database\Schema\Structure\Table;
use FastD\Database\Schema\Structure\Field;
use FastD\Database\Schema\Structure\Key;

class SchemaTest extends \PHPUnit_Framework_TestCase
{
    public function testTableCreateSchema()
    {
        $testTable = new Table('test');

        $testTable->addField(new Field('name', Field::VARCHAR, 11), new Key(Key::INDEX));
        $testTable->addField(new Field('age', Field::INT, 11));

        $schema = Schema::table($testTable);
        $this->assertEquals(<<<EOF
CREATE TABLE `test` (
`name` varchar(11)  NOT NULL DEFAULT ""  COMMENT "",
`age` int(11)  NOT NULL DEFAULT "0"  COMMENT "",
KEY `index_name` (`name`)
) ENGINE InnoDB CHARSET utf8 COMMENT "";
EOF
            ,
            $schema->create()
        );

        $testTable = new Table('test', '测试备注', true);

        $testTable->addField(new Field('name', Field::VARCHAR, 11), new Key(Key::INDEX));
        $testTable->addField(new Field('age', Field::INT, 11));
        $testTable->addField(new Field('bir', Field::INT, 10));
        $testTable->setEngine('myisam');
        $testTable->setCharset('gb2312');

        $this->assertEquals(<<<EOF
CREATE TABLE `test` (
`name` varchar(11)  NOT NULL DEFAULT ""  COMMENT "",
`age` int(11)  NOT NULL DEFAULT "0"  COMMENT "",
`bir` int(10)  NOT NULL DEFAULT "0"  COMMENT "",
KEY `index_name` (`name`)
) ENGINE myisam CHARSET gb2312 COMMENT "测试备注";
EOF
            ,
            Schema::table($testTable)->create()
        );
    }

    public function testTableCreateKeySchema()
    {
        $testTable = new Table('test', '测试');

        $id = new Field('id', Field::INT, 11, false, '', '主键id');
        $id->setKey(new Key(Key::PRIMARY));
        $id->setIncrement(1);

        $testTable->addField($id);
        $testTable->addField(new Field('name', Field::VARCHAR, 10));

        $this->assertEquals(<<<EOF
CREATE TABLE `test` (
`id` int(11)  NOT NULL DEFAULT "0" AUTO_INCREMENT COMMENT "主键id",
`name` varchar(10)  NOT NULL DEFAULT ""  COMMENT "",
PRIMARY KEY (`id`)
) ENGINE InnoDB CHARSET utf8 COMMENT "测试";
EOF
            , Schema::table($testTable)->create()
        );

        $testTable = new Table('test', '测试');

        $id = new Field('id', Field::INT, 11, false, '', '主键id');
        $id->setKey(new Key(Key::PRIMARY));

        $testTable->addField($id);
        $testTable->addField(new Field('name', Field::VARCHAR, 10));

        $this->assertEquals(<<<EOF
CREATE TABLE `test` (
`id` int(11)  NOT NULL DEFAULT "0"  COMMENT "主键id",
`name` varchar(10)  NOT NULL DEFAULT ""  COMMENT "",
PRIMARY KEY (`id`)
) ENGINE InnoDB CHARSET utf8 COMMENT "测试";
EOF
            , Schema::table($testTable)->create()
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
            , Schema::table($testTable)->create()
        );
    }

    public function testTableAlterSchema()
    {
        $testTable = new Table('test');

        $testTable->addField(new Field('nickname', Field::VARCHAR, 11), new Key(Key::INDEX));

        $this->assertEquals('', Schema::table($testTable)->update());

        $testTable = new Table('test');

        $testTable->addField(new Field('name', Field::VARCHAR, 11), new Key(Key::INDEX));
        // Cache success
        $this->assertEquals(array_keys(Schema::table($testTable)->getCache()), ['name', 'age', 'bir', 'id', 'code', 'nickname']);
    }

    public function testTableDropSchema()
    {
        $demoTable = new Table('demo');

        $this->assertEquals(Schema::table($demoTable)->drop(), <<<EOF
DROP TABLE `demo`;
EOF
);

        $this->assertEquals(Schema::table($demoTable, true)->drop(), <<<EOF
DROP TABLE IF EXISTS `demo`;
EOF
);
    }

    public function testMultiTableSchema()
    {
        $demoTable = new Table('demo');

        $demoTable->addField(new Field('id', Field::INT, 10));

        Schema::table($demoTable)->create();
    }
}
