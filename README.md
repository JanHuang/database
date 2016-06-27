# FastD Database

[![Latest Stable Version](https://poser.pugx.org/fastd/database/v/stable)](https://packagist.org/packages/fastd/database) [![Total Downloads](https://poser.pugx.org/fastd/database/downloads)](https://packagist.org/packages/fastd/database) [![Latest Unstable Version](https://poser.pugx.org/fastd/database/v/unstable)](https://packagist.org/packages/fastd/database) [![License](https://poser.pugx.org/fastd/database/license)](https://packagist.org/packages/fastd/database)

好复杂...

## 环境要求

* PHP >= 7
* fastd/generator >= 1.0.0
* fastd/pagination >= 1.0.0

## Composer

```json
{
    "require": {
        "fastd/database": "~2.0.0"
    }
}
```

###

不开玩笑, 我觉得我真实太能折腾了, 明明有好用现成的, 还要自己操心.

数据表生成及操作对象映射结构如下:

```
+------------+          +---------------+
|            |          |               |
|   Tables   |<-------->| SchemaBuilder |--------------+
|            |          |               |              v
+------------+          +---------------+       +-------------+          +--------------+
                                                |             |          |              |
                                                |   Schema    |-+------->| SchemaCache  |
                                                |             | |        |              |
+-----------+          +----------------+       +-------------+ |        +--------------+
|           |          |                |              ^        |
|    DB     |<-------->|  SchemaParser  |--------------+        |
|           |          |                |                       |
+-----------+          +----------------+                       |
                                                                |
                                                                |
                                                                |
                                                                |
                                                                v
                                                        +--------------+
                                                        |              |
                                                        | SchemaReflex |
                                                        |              |
                                                        +--------------+
```

### 1. 基础使用

##### 1.1 配置

```php
$fdb = new Fdb([
    "read" => [
        'database_host'      => '{host}',
        'database_port'      => '{port}',
        'database_name'      => '{dbname}',
        'database_user'      => '{user}',
        'database_pwd'       => '{pwd}'
    ],
    "write" => [
        'database_host'      => '{host}',
        'database_port'      => '{port}',
        'database_name'      => '{dbname}',
        'database_user'      => '{user}',
        'database_pwd'       => '{pwd}'
    ],
]);
```

即使在配置一个数据库链接的时候,都应该使用二维数组的形式进行配置注入.

获取驱动后可以进行最基础的操作, 因为驱动只是在 PDO 上封装了一层, 具体处理和 PDO 并无差别.

##### 1.2 查询构建器

```php
use FastD\Database\Query\MySQLQueryBuilder;

$queryBuilder = new MySQLQueryBuilder();

echo $queryBuilder->from('test'); // SELECT * FROM `test`;
echo $queryBuilder->select(['name'])->from('test'); // SELECT `name` FROM `test`
echo $queryBuilder->select(['name'])->from('test')->where(['name' => 'jan']); // SELECT `name` FROM `test` WHERE `name` = 'jan';
```

**查询构建器仅限用于简单查询,不提供复杂的查询**

##### 1.3 数据库连接驱动

```php
$fdb->getDriver('read'); // return DriverInterface.
```

##### 1.4 模型

模型的概念和普通框架的保持一致,可以手动新建。

```php
class DemoModel extends Model
{
    const TABLE = 'base';
}
```

**手动创建的模型需要指定表名。**

可以通过 `Reflex` 进行映射。使用映射前,需要满足一下其中一个条件。

1. 已有数据库是否存在数据表
2. 是否有构建数据schema。

```php
use FastD\Database\Schema\SchemaParser;

$schemaDriver = new SchemaParser($driver);

$schemaDriver->getSchemaReflex()->reflex(
    __DIR__ . '/Reflex/' . $driver->getDbName(),
    'Test\\' . $driver->getDbName()
);
```

映射后会生成所有的实体对象,模型对象,因此会更加方便使用各个对象。

```php
use FastD\Database\Schema\SchemaBuilder;

$builder = new SchemaBuilder();

$testTable = new Table('test');

$builder->addTable($testTable);

$builder->getSchemaReflex()->reflex(
    __DIR__ . '/Reflex',
    'Test\\'
);
```

通过构建数据表 Schema 生成对象。使用方法和映射表一样,快速生成和构建实例对象。

##### 1.5 实体

实体需要通过映射生成,手动创建也可,但工序复杂。

实体均继承 `\FastD\Database\ORM\Entity`。

理解: 没个实体相当于对应一行具体的记录数, 通过 getter/setter 对其数据进行或去, 通过 `toJson`, `toArray`, `toSerialize` 方法对其进行结果集处理。

而且实体对象实现 `\ArrayAccess` 对象, 所以在使用上和数组操作没有区别。

```php
$entity = new BaseEntity(DriverInterface, ['id' => 1]);

$entity->getName(); // joe
$entity->toArray(); // json_encode([], JSON_NUMERIC_CHECK);
```

以上操作原理上仅是执行了一个简单的数据库 key/value 查询操作,并且其本身没有过多关系和复杂的设计,因此可以保证在速度上不会有太大的损耗。

##### 1.6 Schema构建与数据填充

填充对象需要实现 `FastD\Database\Fixtures\FixtureInterface` 抽象接口,对应实现方法。

```php
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
```

整个 `fixture` 对象需要先执行 `loadSchema` 方法,生成对应的实体对象, 才执行 `loadDataSet` 方法,对其进行数据填充。

### 附言

望大家多多指点啦.

## License MIT