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
    public function testCreateSchemaBuilder()
    {
        $builder = new SchemaBuilder();

        $testTable = new Table('test');

        $testTable->addField(new Field('id', Field::INT, 10), new Key(Key::PRIMARY));

        $builder->addTable($testTable);

        $schema = $builder->update();

        if (!$builder->hasCacheField()) {
            $this->assertEquals(<<<EOF
CREATE TABLE `test` (
`id` int(10) UNSIGNED NOT NULL   COMMENT ""
) ENGINE InnoDB CHARSET utf8 COMMENT "";
EOF
            , $schema);
        }
    }

    public function testCreateSchemaBuilderIfCacheExistsEmptySchema()
    {
        $builder = new SchemaBuilder();

        $testTable = new Table('test');

        $testTable->addField(new Field('id', Field::INT, 10));

        $builder->addTable($testTable);

        $schema = $builder->setCurrentTable($testTable)->update();

        if ($builder->hasCacheField()) {
            $this->assertEquals('', $schema);
        }
    }

    public function testAlterSchemaBuilder()
    {
        $builder = new SchemaBuilder();

        $testTable = new Table('test');

        $testTable->alterField('id', new Field('id', Field::INT, 10));

        $builder->addTable($testTable);

        $schema = $builder->setCurrentTable($testTable)->update();

        if ($builder->hasCacheField()) {
//            $this->assertEquals('ALTER TABLE `test` CHANGE `id` `id` int(11)  NOT NULL DEFAULT "0"  COMMENT "";', $schema);
        }
    }

    public function testDropSchemaBuilder()
    {
        $builder = new SchemaBuilder();

        $testTable = new Table('test');

        $builder->addTable($testTable);
        
        $this->assertEquals($builder->setCurrentTable($testTable)->drop(), 'DROP TABLE `' . $testTable->getFullTableName() . '`;');
        $this->assertEquals($builder->setCurrentTable($testTable)->drop(true), 'DROP TABLE IF EXISTS `' . $testTable->getFullTableName() . '`;');
    }
}
