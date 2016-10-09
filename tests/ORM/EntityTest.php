<?php
/**
 *
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2016
 *
 * @link      https://www.github.com/janhuang
 * @link      http://www.fast-d.cn/
 */

namespace Database\Tests\ORM;

use FastD\Database\Query\QueryBuilder;
use FastD\Database\Schema\Structure\Rename;
use Tests\Fixture_Database_TestCast;
use Test\Dbunit\Entities\BaseEntity;

class EntityTest extends Fixture_Database_TestCast
{
    use Rename;

    public function testEntityInit()
    {
        $entity = new BaseEntity($this->getLocalDriver(), ['id' => 1]);

        $this->assertEquals('joe', $entity->getName());
        $this->assertEquals(json_encode($entity->toArray(), JSON_NUMERIC_CHECK), $entity->toJson());
        $this->assertEquals(1, $entity->getId());

        $this->assertInstanceOf(QueryBuilder::class, $entity->getQueryBuilder());
    }

    public function testAddEntity()
    {
        $entity = new BaseEntity($this->getLocalDriver());
        $entity->setCreateAt(time());
        $entity->setName('jan');
        $entity->setContent('hello world');

        $this->assertEquals(3, $entity->save());
    }

    public function testUpdateEntity()
    {
        $entity = new BaseEntity($this->getLocalDriver(), ['id' => 2]);
        $entity->setCreateAt(time());

        $this->assertEquals(1, $entity->save());
        $this->assertEquals(2, $entity->getId());
    }

    public function testEntitySave()
    {
        $entity = new BaseEntity($this->getLocalDriver());

        $entity->setCreateAt(time());
        $entity->setName('jan');
        $entity->setContent('hello world');

        $this->assertEquals(3, $entity->save());

        $this->assertEquals([
            'name' => 'jan',
            'content' => 'hello world',
            'id' => 3,
            'createAt' => time(),
        ], $entity->toArray());
    }

    public function testEntityFind()
    {
        $entity = new BaseEntity($this->getLocalDriver(), [
            'createAt' => 1272100523
        ]);

        $this->assertEquals([
            'name' => 'joe',
            'content' => 'Hello buddy!',
            'id' => 1,
            'createAt' => '1272100523',
        ], $entity->toArray());
    }
}
