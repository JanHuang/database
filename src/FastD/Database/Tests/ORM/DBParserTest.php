<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/12/18
 * Time: 下午9:51
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Database\Tests\ORM;

use FastD\Database\Drivers\MySQL;
use FastD\Database\ORM\Parser\DBParser;

class DBParserTest extends \PHPUnit_Framework_TestCase
{
    protected function getDB()
    {
        return new MySQL([
            'database_type' => 'mysql',
            'database_user' => 'root',
            'database_pwd'  => '123456',
            'database_host' => '127.0.0.1',
            'database_port' => 3306,
            'database_name' => 'test',
        ]);
    }

    protected function getDBParser()
    {
        return new DBParser($this->getDB());
    }

    public function testDBParser()
    {
        $DBParser = $this->getDBParser();

        $table = $DBParser->getTable('test');

        print_r($table->getFields());
    }
}
