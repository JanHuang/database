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
     * @var \Dobee\Database\Database
     */
    private $database;

    public function setUp()
    {
        $this->database = new \Dobee\Database\Database(array(
            'read' => array(
                'database_type' => 'mysql',
                'database_host' => '127.0.0.1',
                'database_port' => '3306',
                'database_user' => 'root',
                'database_pwd' => '123456',
                'database_charset' => 'utf8',
                'database_name' => 'sf_blog',
                'database_prefix' => 'sf_',
            ),
            'write' => array(
                'database_type' => 'mysql',
                'database_host' => '127.0.0.1',
                'database_port' => '3306',
                'database_user' => 'root',
                'database_pwd' => '123456',
                'database_charset' => 'utf8',
                'database_name' => 'sf_blog',
                'database_prefix' => 'sf_',
            ),
            'test' => array(
                'database_type' => 'mysql',
                'database_host' => '127.0.0.1',
                'database_port' => '3306',
                'database_user' => 'root',
                'database_pwd' => '123456',
                'database_charset' => 'utf8',
                'database_name' => 'test',
                'database_prefix' => '',
            ),
        ));
    }

    public function testConnection()
    {
        $read = $this->database->getConnection('read');

        print_r($read);
    }
}