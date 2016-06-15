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

use FastD\Database\Schema\Field;
use FastD\Database\Schema\Key;
use FastD\Database\Schema\Schema;
use FastD\Database\Schema\Table;

class TableTest extends \PHPUnit_Framework_TestCase
{
    public function testTableCreateSchema()
    {
        $testTable = new Table('test');

        $testTable->addField(new Field('name', Field::VARCHAR, 11), new Key(Key::INDEX));
        $testTable->addField(new Field('age', Field::INT, 11));

        $this->assertEquals(<<<EOF
CREATE TABLE `test` (
`name` varchar(11)  NOT NULL DEFAULT ""  COMMENT "",
`age` int(11)  NOT NULL DEFAULT "0"  COMMENT "",
KEY `index_name` (`name`)
) ENGINE InnoDB CHARSET utf8 COMMENT "";
EOF
            ,
            Schema::table($testTable)->create()
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

        // 第一次会添加, 第二次操作,添加缓存后则不会添加。
        $testTable->addField(new Field('name', Field::VARCHAR, 11), new Key(Key::INDEX));
        $testTable->alterField('name', new Field('name', Field::CHAR, 20));
        $testTable->dropField('name');
    }

    public function testTableDropSchema()
    {
//        echo 'Table Drop Schema' . PHP_EOL;

        $testTable = new Table('test');

//        echo Schema::table($testTable)->drop();
//        echo $testTable->drop();
    }
}
