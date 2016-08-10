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

use FastD\Database\ORM\Model;
use Tests\Fixture_Database_TestCast;
use Test\Dbunit\Models\BaseModel;
use Test\Rename\Dbunit\Fields\Demo;

class TestModel extends Model
{
    const TABLE = 'demo';
}

class DemoModel extends Model
{
    const TABLE = 'base';
}

class ModelTest extends Fixture_Database_TestCast
{
    public function testModel()
    {
        $model = new BaseModel($this->getLocalDriver());

        $this->assertEquals(2, $model->count());
        $this->assertEquals(1, $model->count(['name' => 'janhuang']));
    }

    public function testBaseModel()
    {
        $testModel = new TestModel($this->getLocalDriver());

        $this->assertEquals(0, $testModel->save(['name' => 'janhuang']));
        $this->assertEquals(0, $testModel->save(['name' => 'janhuang'], ['id' => 1]));
    }

    public function testTableModel()
    {
        $model = new DemoModel($this->getLocalDriver());

        $model->findAll();

        $this->assertEquals($model->getLogs(), [
            'SELECT * FROM `base`;'
        ]);
    }
}
