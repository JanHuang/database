<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 16/2/26
 * Time: 下午9:37
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Database\Tests\Orm;

use FastD\Database\Tests\Fixture_Database_TestCast;
use Examples\Orm\Repository\BaseRepository;

class ParamsTest extends Fixture_Database_TestCast
{
    const CONNECTION = [
        'database_host' => '127.0.0.1',
        'database_port' => '3306',
        'database_name' => 'dbunit',
        'database_user' => 'root',
        'database_pwd' => '123456'
    ];

    public function testParams()
    {
        $baseRepository = new BaseRepository($this->createDriver());

        $baseRepository->bindParams([
            'name' => 'asdf',
            'content' => 'hello',
            'createAt' => 123123
        ]);

        $this->assertEquals(3, $baseRepository->save());
    }
}