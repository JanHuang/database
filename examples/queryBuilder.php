<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/12/16
 * Time: 上午11:13
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

include __DIR__ . '/../vendor/autoload.php';

use FastD\Database\Drivers\Query\MySQLQueryBuilder;

$mysqlQueryBuilder = new MySQLQueryBuilder();

$select = $mysqlQueryBuilder
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

echo $select;

// SELECT * FROM `test` WHERE `name`!='' AND `age`>'18';