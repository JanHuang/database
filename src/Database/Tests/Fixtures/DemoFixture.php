<?php
/**
 *
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2016
 *
 * @link      https://www.github.com/janhuang
 * @link      http://www.fast-d.cn/
 */

namespace FastD\Database\Tests\Fixtures;

use FastD\Database\Fixtures\FixtureInterface;
use FastD\Database\Drivers\DriverInterface;
use FastD\Database\Schema\Structure\Field;
use FastD\Database\Schema\Structure\Table;
use Test\Rename\Dbunit\Entities\BaseEntity;

class DemoFixture implements FixtureInterface
{
    /**
     * Create schema
     *
     * @return Table
     */
    public function loadSchema()
    {
        $table = new Table('demo');

        $table->addField(new Field('id', Field::INT, 10));
        $table->addField(new Field('name', Field::VARCHAR, 20));
        $table->addField(new Field('nickname', Field::VARCHAR, 30));
        $table->addField(new Field('bir', Field::INT, 10));
        $table->alterField('nickname', new Field('nickname', Field::CHAR, 30));
        $table->dropField('bir');

        return $table;
    }

    /**
     * Fill DB data.
     *
     * @param DriverInterface $driverInterface
     * @return mixed
     */
    public function loadDataSet(DriverInterface $driverInterface)
    {
        $baseEntity = new BaseEntity($driverInterface);

        $baseEntity->setContent('test');

        $baseEntity->save();
    }
}