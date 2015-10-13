<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/10/11
 * Time: 上午1:13
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Database\Tests\ORM;

use FastD\Database\ORM\Builder;

class BuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testORMBuilder()
    {
        $builder = new Builder();

        $builder->addStruct(
            [
                'table' => 'demo',
                'suffix' => '',
                'preffix' => '',
                'repository' => '', // 默认值 Entity/../Repository
                'cache' => '', // 默认值 Entity/cache/md5.php
                'engine' => 'innodb', // 默认innodb
                'charset' => 'utf8', // 默认utf8
                'primary' => [
                    'name' => 'id', // 默认值 name 拆分
                    'type' => 'int',
                    'length' => 10,
                    'default' => 0,
                    'comment' => '',
                    'increment' => 10, // 起始值
                    'unsigned' => true, // 默认false
                ],
                'fields' => [
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

        $builder->addStruct(
            [
                'table' => 'test',
                'suffix' => '',
                'preffix' => '',
                'repository' => '', // 默认值 Entity/../Repository
                'cache' => '', // 默认值 Entity/cache/md5.php
                'engine' => 'innodb', // 默认innodb
                'charset' => 'utf8', // 默认utf8
                'fields' => [
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

        $builder->buildEntity(__DIR__ . '/../Entity', 'Deme\\');

//        $this->getConnection()->getRepository()->findAll(); // return Entity[]
    }
}