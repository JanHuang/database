<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/12/16
 * Time: 下午5:37
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

include __DIR__ . '/../vendor/autoload.php';

use FastD\Database\ORM\Generator\Builder;

$builder = new Builder();

$builder->addStruct(
    [
        'table' => 'test',
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
                'primary' => true,
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
    ]
);

$createTableSql = $builder->buildSql();

$namespace = 'Examples\\';

$builder->buildEntity(__DIR__, $namespace);
