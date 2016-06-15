<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 16/2/26
 * Time: 上午10:18
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

class KeyTest extends \PHPUnit_Framework_TestCase
{
    public function testKey()
    {
        $key = new Key('name');

        $this->assertEquals($key->toSql(Field::FIELD_CHANGE), "ADD INDEX `index_name` (`name`)");
        $this->assertEquals($key->toSql(Field::FIELD_DROP), 'DROP INDEX `index_name`');
        $this->assertEquals($key->toSql(Field::FIELD_CREATE), 'KEY `index_name` (`name`)');

        $key = new Key('id', Key::KEY_PRIMARY);

        $this->assertEquals('PRIMARY KEY (`id`)', $key->toSql(Field::FIELD_CREATE));
        $this->assertEquals('DROP PRIMARY KEY', $key->toSql(Field::FIELD_DROP));
        $this->assertEquals('ADD PRIMARY KEY (`id`)', $key->toSql(Field::FIELD_CHANGE));
    }
}
