#FastD Database

好复杂...

## 依赖

* PHP >= 7
* fastd/generator >= 1.0
* symfony/yaml >= 3.0

## Install 

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
        'host'      => '{host}',
        'port'      => '{port}',
        'dbname'    => '{dbname}',
        'user'      => '{user}',
        'pwd'       => '{pwd}'
    ],
    "write" => [
        'host'      => '{host}',
        'port'      => '{port}',
        'dbname'    => '{dbname}',
        'user'      => '{user}',
        'pwd'       => '{pwd}'
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
        'host'      => '{host}',
        'port'      => '{port}',
        'dbname'    => '{dbname}',
        'user'      => '{user}',
        'pwd'       => '{pwd}'
    ],
    "write" => [
        'host'      => '{host}',
        'port'      => '{port}',
        'dbname'    => '{dbname}',
        'user'      => '{user}',
        'pwd'       => '{pwd}'
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
        'host'      => '{host}',
        'port'      => '{port}',
        'dbname'    => '{dbname}',
        'user'      => '{user}',
        'pwd'       => '{pwd}'
    ],
    "write" => [
        'host'      => '{host}',
        'port'      => '{port}',
        'dbname'    => '{dbname}',
        'user'      => '{user}',
        'pwd'       => '{pwd}'
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

```
$root/Orm
         \ Entity
         \ Repository
         \ Field
         \ yml
```

其他测试我就不说明了, `Entity`, `Repository` 操作就自行使用, 和其他数据库操作雷同, 相信大家这么聪明不是什么问题, 具体可看测试用例.

望大家多多指点啦. 



## License MIT