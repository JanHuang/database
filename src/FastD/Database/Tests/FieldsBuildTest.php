<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/8/1
 * Time: 下午2:50
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Database\Tests;

use FastD\Database\Tests\Repository\DemoRepository;

class FieldsBuildTest extends \PHPUnit_Framework_TestCase
{
    public function testBuildFields()
    {
        $demo = new DemoRepository();
        $data = [
            'id' => '10',
            'name' => 'janhuang',
            'asasd' => ['demo'],
            'roles' => ['ROLE_ADMIN', 'ROLE_USER'],
        ];

        $data = $demo->buildTableFieldsData($data);
        $this->assertEquals([
            'id' => 10,
            'name' => 'janhuang',
            'roles' => '["ROLE_ADMIN","ROLE_USER"]',
        ], $data);

        $data = $demo->parseTableFieldsData($data);
        $this->assertEquals([
            'id' => '10',
            'name' => 'janhuang',
            'roles' => ['ROLE_ADMIN', 'ROLE_USER'],
        ], $data);
    }
}