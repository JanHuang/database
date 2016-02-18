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

include __DIR__ . '/boot.php';

use FastD\Database\Drivers\MySQL;
use FastD\Database\ORM\Generator\Mapping;

$mysql = new MySQL([
    'database_type' => 'mysql',
    'database_user' => 'root',
    'database_pwd'  => '123456',
    'database_host' => '127.0.0.1',
    'database_port' => 3306,
    'database_name' => 'fd_db',
]);

$builder = new Mapping($mysql);


$builder->addTable(
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
                'unsigned' => true, // 默认false
                'key' => 'primary',
            ],
            'trueName' => [
                'name' => 'true_name',
                'type' => 'char',
                'length' => 20,
                'notnull' => true, // 默认true
                'default' => '',
//                'key' => 'index'
            ],
            'nickName' => [
                'name' => 'nick_name',
                'type' => 'varchar',
                'length' => 20,
                'notnull' => true, // 默认true
                'default' => '',
//                'key' => 'index' // 默认索引名为 name_unique_key
            ],
            'age' => [
                'name' => 'age',
                'type' => 'smallint',
                'length' => 2,
                'notnull' => true, // 默认true
                'default' => 1,
//                'key' => 'unique' // 默认索引名为 name_unique_key
            ],
            'gender' => [
                'name' => 'gender',
                'type' => 'tinyint',
                'length' => 1,
                'notnull' => true, // 默认true
                'default' => 1,
//                'key' => 'unique' // 默认索引名为 name_unique_key
            ],
        ]
    ]
);
echo '<pre>';
$tables = $builder->updateTables();
$builder->buildEntity('Examples\\ORM', __DIR__);
print_r($tables);
//$builder->buildEntity(__DIR__, 'Examples\\');
