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

```php


```

## License MIT