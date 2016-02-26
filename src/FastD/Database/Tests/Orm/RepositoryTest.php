<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 16/2/26
 * Time: 下午7:25
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Database\Tests\Orm;

use Examples\Orm\Repository\BaseRepository;
use FastD\Database\Tests\Fixture_Database_TestCast;

class RepositoryTest extends Fixture_Database_TestCast
{
    const CONNECTION = [
        'host' => '127.0.0.1',
        'port' => '3306',
        'dbname' => 'dbunit',
        'user' => 'root',
        'pwd' => '123456'
    ];

    public function testFind()
    {
        $baseRepository = new BaseRepository($this->createDriver());

        $row = $baseRepository->where(['name' => 'joe'])->find();

        $this->assertEquals('joe', $row['name']);

        $list = $baseRepository->findAll();

        $this->assertEquals(1, $list[0]['id']);

        $list = $baseRepository->orderBy(['id' => 'DESC'])->findAll();

        $this->assertEquals(2, $list[0]['id']);
    }

    public function testSave()
    {
        $baseRepository = new BaseRepository($this->createDriver());

        $this->assertEquals(3, $baseRepository->save([
            'content' => 'hello',
            'name' => 'test'
        ]));

        $this->assertEquals(4, $baseRepository->save([
            'content' => ':content',
            'name' => 'test'
        ], [], ['content' => 'hello']));

        $this->assertEquals(1, $baseRepository->save([
            'content' => 'hello',
            'name' => 'test'
        ], ['id' => 1]));
    }
}