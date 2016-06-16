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

use FastD\Database\Tests\Fixture_Database_TestCast;
use Test\Dbunit\Models\BaseModel;
use Test\Dbunit\Entities\BaseEntity;

class ParamsTest extends Fixture_Database_TestCast
{
    public function testParamsBind()
    {
        $model = new BaseModel($this->getLocalDriver());

        $model->bindParams([
            'name' => 'janhuang',
            'content' => 'test content'
        ]);

        $entity = new BaseEntity($this->getLocalDriver());

        $entity->bindParams([
            'name' => 'janhuang',
            'content' => 'test content'
        ]);

        $this->assertEquals('janhuang', $entity->getName());
    }
}
