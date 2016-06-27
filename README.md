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



##### 1.5 实体

##### 1.6 Schema构建与数据填充

望大家多多指点啦.

## License MIT