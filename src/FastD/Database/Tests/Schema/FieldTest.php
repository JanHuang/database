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

class FieldTest extends \PHPUnit_Framework_TestCase
{
    public function testField()
    {
        $name = new Field('name', 'varchar', 10);

        $this->assertEquals('name', $name->getName());

        $this->assertEquals('name', $name->getAlias());

        $this->assertFalse($name->isNullable());
        $this->assertFalse($name->isUnsigned());
        $this->assertEquals('', $name->getDefault());
    }
}
