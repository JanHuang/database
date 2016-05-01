# FastD Database

[![Latest Stable Version](https://poser.pugx.org/fastd/database/v/stable)](https://packagist.org/packages/fastd/database) [![Total Downloads](https://poser.pugx.org/fastd/database/downloads)](https://packagist.org/packages/fastd/database) [![Latest Unstable Version](https://poser.pugx.org/fastd/database/v/unstable)](https://packagist.org/packages/fastd/database) [![License](https://poser.pugx.org/fastd/database/license)](https://packagist.org/packages/fastd/database)

好复杂...

## 环境要求

* PHP >= 7
* fastd/generator >= 1.0
* symfony/yaml >= 3.0

## Composer

```
composer require "fastd/database:2.0.x.dev"
phpunit
```

不开玩笑, 我觉得我真实太能折腾了, 明明有好用现成的, 还要自己操心.

很可惜还没实现 `ORM`

### 1. 数据库配置

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

$read = $fdb->getDriver('read');

$all = $read->query('show tables')->execute()->getAll();
```

即使再配置一个数据库链接的时候,都应该使用二维数组的形式进行配置注入.

获取驱动后可以进行最基础的操作, 因为驱动只是在 PDO 上封装了一层, 具体处理和 PDO 并无差别.

### 2. 自动生成

这个可是我折腾出来的成果, 也是太能折腾了, 哈哈.

#### 2.1 通过 yml 配置文件构建数据表

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

// AutoBuilding 第二个参数是 yml 文件存放的目录, 程序会自动扫面 *.yml 文件进行解析, yml 解析依赖 symfony/yaml 组件
$auto = new AutoBuilding($fdb->getDriver('read'), {path});

// 第一个是生成的目录路径, 最终会在该目录下产生 yml, Entity, Repository, Field 等目录, 对应 "表" -> "文件" 的一对一形式
// 第二个参数是生成对象的命名空间
// 第三个参数确定是否强制操作
// 第四个取决于数据表是创建还是其他操作, 分别有 TABLE_CREATE, TABLE_CHANGE, TABLE_DROP TABLE_ADD 四个操作
$auto->ymlToTable($root . '/Orm', 'Examples\Orm', true, Table::TABLE_CREATE);
```

最终生成目录结构:

```
$root/Orm
         \ Entity
         \ Repository
         \ Field
```

#### 2.2 通过已有数据表生成 yml 配置文件

这个还是比较 6 的.

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

// AutoBuilding 第二个参数是 yml 文件存放的目录, 程序会自动扫面 *.yml 文件进行解析, yml 解析依赖 symfony/yaml 组件
$auto = new AutoBuilding($fdb->getDriver('read'), null);

// 第一个是生成的目录路径, 最终会在该目录下产生 yml, Entity, Repository, Field 等目录, 对应 "表" -> "文件" 的一对一形式
// 第二个参数是生成对象的命名空间
// 第三个参数确定是否强制操作
$auto->tableToYml($root . '/Orm', 'Examples\Orm', true);
```

最终生成目录结构: 最后会多一个 `yml` 目录, 用于存储映射出来的 `yml` 配置文件.

每个生成的目录按照不同的数据库名进行归类

```
$root/Orm/{dbname}
         \ Entity
         \ Repository
         \ Field
         \ yml
```

其他测试我就不说明了, `Entity`, `Repository` 操作就自行使用, 和其他数据库操作雷同, 相信大家这么聪明不是什么问题, 具体可看测试用例.

### 3. 分页

数据分页对象

#### 3.1 通用分页

```php
$page = new Pagination(100, 1, [$showList = 25], [$showPage = 5])
$page->getFirstPage();
```

通用分页只需要注入总数量，当前页码，每页显示数量，每次显示多少页即刻获得分页数据。

#### 3.2 查询分页

```php
$repository = new BaseRepository($this->createDriver());
$page = new QueryPagination($repository, 1);
$page->getResult();
```

继承通用分页特性，需要注入一个数据操作仓库，具体数据查询和分页由内部实现。分别会调用 `Repository::count` 和 `Repository::findAll` 两个方法，通过 `QueryPagination::getResult` 方法获取分页数据

望大家多多指点啦.

## License MIT