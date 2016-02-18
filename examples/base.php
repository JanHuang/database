<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/12/12
 * Time: 下午12:14
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

include __DIR__ . '/../vendor/autoload.php';

use FastD\Database\DBPool;

$db = new DBPool([
    'test' => [
        'database_type' => 'mysql',
        'database_user' => 'root',
        'database_pwd'  => '123456',
        'database_host' => '127.0.0.1',
        'database_port' => 3306,
        'database_name' => 'test',
    ]
]);

$driver = $db->getDriver('test');
echo '<pre>';
print_r($driver);

