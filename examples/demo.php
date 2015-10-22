<?php
/**
 * FD database component
 * Version 2.0.0
 *
 *
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/10/21
 * Time: 下午11:03
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

include __DIR__ . '/../vendor/autoload.php';

$db = new \FastD\Database\Database([
    'test' => [
        'database_type' => 'mysql',
        'database_user' => 'root',
        'database_pwd'  => '123456',
        'database_host' => '127.0.0.1',
        'database_port' => 3306,
        'database_name' => 'demo',
    ]
]);

function createTable(\FastD\Database\Driver\Driver $driver)
{
    $builder = new \FastD\Database\ORM\Generator\Builder();
    $builder->addStruct([
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
    ]);

    $result = [];

    foreach ($builder->buildSql() as $sql) {
        $result[] = $driver->createQuery($sql)->getQuery()->getQueryString();
    }

    return createMapper($builder);
}

function createMapper(\FastD\Database\ORM\Generator\Builder $builder)
{
    $builder->buildEntity('./', 'Examples\\');

    return true;
}

$connection = $db->getConnection('test');

$createResult = createTable($connection);

$demoRepository = new \Examples\Repository\DemoRepository($connection);

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


