<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/12/16
 * Time: 下午4:49
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

include __DIR__ . '/../vendor/autoload.php';

use FastD\Database\Drivers\MySQL;

$driver = new MySQL([
    'database_user' => 'root',
    'database_pwd'  => '123456',
    'database_host' => '127.0.0.1',
    'database_port' => 3306,
    'database_name' => 'test',
]);

$repository = $driver->getRepository('Examples:Repository:Test');

echo '<pre>';
print_r($repository);

echo $repository->count();

