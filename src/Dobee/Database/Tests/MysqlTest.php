<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/4/14
 * Time: 上午9:55
 * Github: https://www.github.com/janhuang 
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 */

namespace Dobee\Database\Tests;

class MysqlTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Dobee\Database\DriverManager
     */
    private $database;

    public function setUp()
    {
        $this->database = new \Dobee\Database\DriverManager(array(
            'default_connection' => 'read',
            'read' => array(
                'database_type' => 'mysql',
                'database_host' => 'localhost',
                'database_port' => '3306',
                'database_user' => 'root',
                'database_pwd' => '123456',
                'database_charset' => 'utf8',
                'database_name' => 'sf_blog',
                'database_prefix' => 'sf_',
            ),
            'write' => array(
                'database_type' => 'mysql',
                'database_host' => 'localhost',
                'database_port' => '3306',
                'database_user' => 'root',
                'database_pwd' => '123456',
                'database_charset' => 'utf8',
                'database_name' => 'sf_blog',
                'database_prefix' => 'sf_',
            ),
        ));
    }

    public function testConnection()
    {
        $read = $this->database->getConnection('read');

        $this->assertInstanceOf('Dobee\Database\Connection\ConnectionInterface', $read);

        try {
            $this->database->getConnection('not_has_connection');
        } catch (\Exception $e) {
            return true;
        }
    }

    public function testFind()
    {
        $read = $this->database->getConnection('read');

        $result = $read->find('sf_post', array('id' => 1));

        $this->assertInstanceOf('\\Dobee\\Database\\QueryResult\\Result', $result);

        $this->assertEquals($result->title, $result['title']);

        $this->assertFalse($read->find('sf_post', array('id' => 111))->getStatus());

        $this->assertFalse($read->find('no_had_table', array('id' => 1))->getStatus());

        $collection = $read->findAll('sf_post');

        $this->assertEquals(2, $collection->count());
    }
}