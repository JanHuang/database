<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/12/30
 * Time: 下午10:05
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

include  __DIR__ . '/../../vendor/autoload.php';

use FastD\Database\Drivers\MySQL;
use FastD\Database\ORM\Generator\Revert;

$mysql = new MySQL([
    'database_type' => 'mysql',
    'database_user' => 'root',
    'database_pwd'  => '123456',
    'database_host' => '127.0.0.1',
    'database_port' => 3306,
    'database_name' => 'test',
]);

$builder = new Revert($mysql);
echo '<pre>';
$builder->build(__DIR__);
//print_r($builder);