<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/12/16
 * Time: 下午6:56
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

include __DIR__ . '/../vendor/autoload.php';

use Examples\Entity\Test;
use FastD\Database\Drivers\MySQL;

$driver = new MySQL([
    'database_user' => 'root',
    'database_pwd'  => '123456',
    'database_host' => '127.0.0.1',
    'database_port' => 3306,
    'database_name' => 'test',
]);

$test = new Test(1, $driver);

echo '<pre>';
echo 'find<br />';
$test->find();
echo $test->getId();
echo $test->getTrueName();
echo $test['trueName'];

echo '<hr />update<br />';
$test->setTrueName('asdad');
echo $test->save();

echo '<hr>insert<br />';
$row = new Test(null, $driver);
$row->setTrueName('test insert');
echo $row->save();