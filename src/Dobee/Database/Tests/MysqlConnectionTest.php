<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/6/18
 * Time: 下午7:54
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */


namespace Dobee\Database\Tests;

use Dobee\Database\Connection\Mysql\MysqlConnection;

class MysqlConnectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MysqlConnection
     */
    private $connection;

    public function setUp()
    {
        $this->connection = new MysqlConnection('mysql:host=127.0.0.1;dbname=test', 'root', '123456');
    }

    public function testBaseCURD()
    {
//        $all = $this->connection->prepare('select * from ws_user')->getQuery()->getAll();
//        $one = $this->connection->prepare('select * from ws_user')->getQuery()->getOne();

        // update
//        echo PHP_EOL . 'Update: ' . $this->connection->prepare('update ws_user set username=\'janhuang\', update_at = '.time())->getQuery()->getAffectedRow() . PHP_EOL;
        // insert
//        echo 'Insert: ' . $this->connection->prepare('insert into ws_user (username) values(\'demo\')')->getQuery()->getLastId() . PHP_EOL;
        // delete wranning
//        echo 'Delete: ' . $this->connection->prepare('delete from ws_user')->getQuery()->getAffectedRow() . PHP_EOL;
    }

    public function testSetParameters()
    {
        $result = $this->connection
            ->prepare('SELECT * FROM ws_user where id = :id')
            ->setParameters('id', 1)
            ->getQuery()
            ->getOne()
        ;
    }
}