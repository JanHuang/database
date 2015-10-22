#FD database and simple ORM


##Install 

```
composer require fastd/database "1.0.*@alpha"
```

##Usage

### 1.Create table structure.

```
'table' => 'demo',
'suffix' => '',
'prefix' => '',
'cache' => '', // 默认值 Entity/cache/md5.php
'engine' => 'innodb', // 默认innodb
'charset' => 'utf8', // 默认utf8
'fields' => [
    'id' => [
        'name' => 'id', // 默认值 name 拆分
        'type' => 'int',
        'length' => 10,
        'default' => 0,
        'comment' => '',
        'increment' => 10, // 起始值
        'unsigned' => true, // 默认false
        'primary' => true
    ],
    'nickname' => [
        'name' => 'nickname',
        'type' => 'varchar',
        'length' => 20,
        'notnull' => true, // 默认true
        'default' => '',
        'index' => 'unique' // 默认索引名为 name_unique_key
    ],
    'catId' => [
        'name' => 'category_id',
        'type' => 'int',
        'default' => 0,
        'index' => 'index',
    ],
    'trueName' => [
        'name' => 'true_name',
        'type' => 'varchar',
        'default' => '',
    ],
]
```

### 2.Append to builder.

```
$builder = new \FastD\Database\ORM\Generator\Builder();
$builder->addStruct(
	$struct
);
```

### 3.Building.

```
$result = [];

foreach ($builder->buildSql() as $sql) {
    $result[] = $driver->createQuery($sql)->getQuery()->getQueryString();
}

$builder->buildEntity('./', 'Examples\\');
```

这里会自动创建 Entity 和 Repository 到当前目录。

### 4.Simple ORM

```
// insert
$demo = new \Examples\Entity\Demo();
$demo->setCatId(mt_rand());
$demo->setNickname('jan' . mt_rand());
$demo->setTrueName('janhuang' . mt_rand());
$demoRepository->save($demo);

// update entity
$demo = new \Examples\Entity\Demo(1);
$demo->setCatId(11);
$demo->setTrueName('janhuang');
$demo->setTrueName('jan');
$demoRepository->save($demo);

// remove
$demo = new \Examples\Entity\Demo(15);
$demoRepository->remove($demo);

// get entity
$demo = $demoRepository->find(['id' => 1]);

echo '<pre>';
print_r($demo->getId());
```

go to: `examples/demo.php`

## License MIT