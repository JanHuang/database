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

$loader = include __DIR__.'/../../vendor/autoload.php';

$loader->setPsr4('Examples\\', __DIR__ . '/../../examples');

use FastD\Database\Drivers\MySQL;
use FastD\Database\ORM\Generator\Mapping;

$mysql = new MySQL([
    'database_type' => 'mysql',
    'database_user' => 'root',
    'database_pwd'  => '123456',
    'database_host' => '127.0.0.1',
    'database_port' => 3306,
    'database_name' => 'test',
]);

$builder = new Mapping($mysql);

echo '<pre>';
$result = $builder->buildEntity('Examples\\ORM', __DIR__);
print_r($result);