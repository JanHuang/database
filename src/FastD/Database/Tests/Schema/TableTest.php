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
use FastD\Database\Schema\Table;

class TableTest extends \PHPUnit_Framework_TestCase
{
    public function testTableCreateSchema()
    {
        echo 'Table Create Schema' . PHP_EOL;
        $testTable = new Table('test');

        $testTable->addField(new Field('name', Field::VARCHAR, 11), new Key(Key::INDEX));
        $testTable->addField(new Field('age', Field::INT, 11));

        echo PHP_EOL;
        echo $testTable->create();

        echo PHP_EOL;

        $testTable = new Table('test', '测试备注', true);

        $testTable->addField(new Field('name', Field::VARCHAR, 11), new Key(Key::INDEX));
        $testTable->addField(new Field('age', Field::INT, 11));

        echo PHP_EOL;
        echo $testTable->create();
    }

    public function testTableAlterSchema()
    {
        echo 'Table Alter Schema' . PHP_EOL;

        $testTable = new Table('test');

        $testTable->addField(new Field('name', Field::VARCHAR, 11), new Key(Key::INDEX));
        $testTable->addField(new Field('age', Field::INT, 11));
    }

    public function testTableDropSchema()
    {
        echo 'Table Drop Schema' . PHP_EOL;

        $testTable = new Table('test');

        echo $testTable->drop();
    }
}
