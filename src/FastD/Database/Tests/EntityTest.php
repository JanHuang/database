<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/9/7
 * Time: 下午10:31
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Database\Tests;

use FastD\Database\Tests\Repository\Demo;

class EntityTest extends \PHPUnit_Framework_TestCase
{
    public function testProcess()
    {
        $demoRepository = new Demo();
        $demoRepository->persist(new \FastD\Database\Tests\Entity\Demo());
    }
}