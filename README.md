#FastD Simple Database

##Install 

```
composer require fastd/database [version]"
```

##Usage

###QueryBuilderInterface

创建查询语句,目前仅提供简单的查询,不支持复杂查询,建议复杂查询手写SQL会比较好,也比较直观.

目前实现的有MySQLQueryBuilder

```php
<?php

include __DIR__ . '/../vendor/autoload.php';

use FastD\Database\Drivers\Query\MySQLQueryBuilder;

$mysqlQueryBuilder = new MySQLQueryBuilder();

$mysqlQueryBuilder
    ->table('test')
    ->where(
        [
            'AND' => [
                'name[!=]' => '',
                'age[>]' => '18'
            ]
        ]
    )
    ->select()
;

echo $mysqlQueryBuilder->getSql();

// SELECT * FROM `test` WHERE `name`!='' AND `age`>'18';
```

###Driver & DriverFactory

####Custom Query

```php
<?php

include __DIR__ . '/../vendor/autoload.php';

use FastD\Database\Drivers\DriverFactory;
use FastD\Database\Drivers\MySQL;

$driver = DriverFactory::createDriver([
    'database_type' => 'mysql',
    'database_user' => 'root',
    'database_pwd'  => '123456',
    'database_host' => '127.0.0.1',
    'database_port' => 3306,
    'database_name' => 'test',
]);
// OR
/*
$driver = new MySQL([
    'database_user' => 'root',
    'database_pwd'  => '123456',
    'database_host' => '127.0.0.1',
    'database_port' => 3306,
    'database_name' => 'test',
]);
*/

$driver
    ->createQuery(
        'select * from test where `name`=:name'
    )
    ->setParameter('name', 'janhuang')
    ->getQuery()
    ->getOne()
    // ->getAll
;

$result = $driver
    ->table('test')
    ->where(['id' => ':id'])
    ->find(['id' => 1])
    // ->findAll
;
```

如果使用 `createQuery` 创建查询,需要使用 `getOne` 或者 `getAll` 进行数据获取.

如果使用一般的链式操作,需要使用 `find` 或者 `findAll` 进行数据获取

####Get PDO & Get PDOStatement

```php
<?php

include __DIR__ . '/../vendor/autoload.php';

use FastD\Database\Drivers\DriverFactory;
use FastD\Database\Drivers\MySQL;

$driver = DriverFactory::createDriver([
    'database_type' => 'mysql',
    'database_user' => 'root',
    'database_pwd'  => '123456',
    'database_host' => '127.0.0.1',
    'database_port' => 3306,
    'database_name' => 'test',
]);

$driver->getPDO();

$driver->getPDOStatement();
```

如果SQL没有进行绑定, `getPDOStatement` 会返回 `NULL`

## License MIT