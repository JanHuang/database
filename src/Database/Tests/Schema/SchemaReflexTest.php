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
use Fastd\Database\Schema\SchemaBuilder;
use FastD\Database\Schema\SchemaReflex;
use FastD\Database\Schema\Structure\Field;
use FastD\Database\Schema\Structure\Table;

class SchemaReflexTest extends \PHPUnit_Framework_TestCase
{
    public function testReflexFields()
    {
        /*$testTable = new Table('test');
        $testTable->addField(new Field('id', Field::INT, 10));

        $reflex = new SchemaReflex([
            SchemaBuilder::table($testTable),
        ]);

        $reflex->reflexFields(__DIR__ . '/Reflex', 'Test');*/
    }
    
    public function testReflexEntities()
    {
        /*$testTable = new Table('test');
        $testTable->addField(new Field('id', Field::INT, 10));

        $reflex = new SchemaReflex([
            SchemaBuilder::table($testTable),
        ]);

        $reflex->reflexEntities(__DIR__ . '/Reflex', 'Test');*/
    }

    public function testReflexModels()
    {
        /*$testTable = new Table('test');
        $testTable->addField(new Field('id', Field::INT, 10));

        $reflex = new SchemaReflex([
            SchemaBuilder::table($testTable),
        ]);

        $reflex->reflexModels(__DIR__ . '/Reflex', 'Test');*/
    }
}
