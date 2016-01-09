<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 16/1/7
 * Time: 上午12:10
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */


include __DIR__ . '/boot.php';

use Examples\ORM\Entity\Test;
use FastD\Http\Request;

$driver = include __DIR__ . '/../getMysql.php';;


echo '<pre>';
$test = new Test(1, $driver);
echo $test->getTrueName();
$test->setTrueName('黄生');
var_dump($test->save());


//$request = Request::createRequestHandle();
//$request->query->set('trueName', '黄总');
//$test->bindRequest($request);
//echo '<pre>';
//var_dump($test->save());

print_r($test);