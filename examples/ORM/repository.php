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

$repository = new \Examples\ORM\Repository\TestRepository($driver);

$request = \FastD\Http\Request::createRequestHandle();
$request->query->set('trueName', '黄');
$repository->bindRequest($request);

echo '<pre>';
print_r($repository->pagination(1, 5, 5, 25)->where(['true_name' => '黄总'])->orderBy(['id' => 'desc'])->getPagination());
//var_dump($repository->findAll());
//var_dump($repository->find());
//var_dump($repository->save([], ['id' => 15]));
//var_dump($repository->count());
//var_dump($repository->pagination(1, 5));
//print_r($repository);
//print_r($repository->findToEntity(['id' => 1]));
/*print_r($repository);
print_r($repository->getFields());
echo $repository->getEntity();
print_r($repository->getDriver());
print_r($repository->count());*/

