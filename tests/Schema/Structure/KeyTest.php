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

use FastD\Database\Schema\Structure\Key;
use FastD\Database\Schema\Structure\Field;

class KeyTest extends \PHPUnit_Framework_TestCase
{
    public function testSchemaKey()
    {
        $id = new Field('id', Field::INT, 11);

        $key = new Key(Key::PRIMARY);
        
        $key->setField($id);

        $this->assertTrue($key->isPrimary());
    }
}
