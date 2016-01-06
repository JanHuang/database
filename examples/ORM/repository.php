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

include  __DIR__ . '/boot.php';

$driver = include __DIR__ . '/../getMysql.php';

$repository = $driver->getRepository('Examples:ORM:Repository:Test');

$request = \FastD\Http\Request::createRequestHandle();
$request->query->set('trueName', '黄总');
$repository->bindRequest($request);

echo '<pre>';
var_dump($repository->save([], ['id' => 1]));
print_r($repository->getQueryBuilder());
echo '<pre>';
$row = $repository->findAll(['id' => 1]);
print_r($row);
//print_r($repository->findToEntity(['id' => 1]));
/*print_r($repository);
print_r($repository->getFields());
echo $repository->getEntity();
print_r($repository->getDriver());
print_r($repository->count());*/

