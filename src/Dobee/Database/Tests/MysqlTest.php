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

    public function testSelectContext()
    {
        $read = $this->database->getConnection('read');

        $read->find('sf_link');

        $this->assertEquals('SELECT * FROM sf_link LIMIT 1;', $read->getSql());

        $read->find('sf_link', ['username' => 'janhuang']);

        $this->assertEquals('SELECT * FROM sf_link WHERE `username`=\'janhuang\' LIMIT 1;', $read->getSql());

        $read->find('sf_link', ['username' => 'janhuang'], ['username', 'password']);

        $this->assertEquals("SELECT `username`,`password` FROM sf_link WHERE `username`='janhuang' LIMIT 1;", $read->getSql());

        $read->find('sf_link', ['AND' => ['username' => 'janhuang', 'password' => '123456']]);

        $this->assertEquals("SELECT * FROM sf_link WHERE `username`='janhuang' AND `password`='123456' LIMIT 1;", $read->getSql());

        $read->find('sf_link', ['OR' => ['username' => 'janhuang', 'password' => '123456']], ['username', 'password']);

        $this->assertEquals("SELECT `username`,`password` FROM sf_link WHERE `username`='janhuang' OR `password`='123456' LIMIT 1;", $read->getSql());
    }

    public function testUpdateContext()
    {
        $write = $this->database->getConnection('write');

        $write->update('sf_links', ['username' => 'jan']);

        $this->assertEquals('UPDATE sf_links SET `username`=\'jan\';', $write->getSql());

        $write->update('sf_links', ['username' => 'jan'], ['username' => 'janhuang']);

        $this->assertEquals('UPDATE sf_links SET `username`=\'jan\' WHERE `username`=\'janhuang\';', $write->getSql());

        $write->update('sf_links', ['username' => 'jan', 'password' => '123456'], ['username' => 'janhuang']);

        $this->assertEquals('UPDATE sf_links SET `username`=\'jan\', `password`=\'123456\' WHERE `username`=\'janhuang\';', $write->getSql());

        $write->update('sf_links', ['username' => 'jan', 'password' => '123456'], ['username' => 'janhuang'], ['username' => 'janhuang']);

        $this->assertEquals('UPDATE sf_links SET `username`=\'jan\', `password`=\'123456\' WHERE `username`=\'janhuang\';', $write->getSql());
    }

    public function testInsertContext()
    {
        $write = $this->database->getConnection('write');

        $write->insert('sf_links', ['username' => 'jan']);

        $this->assertEquals('INSERT INTO sf_links(`username`) VALUES (\'jan\');', $write->getSql());

        $write->insert('sf_links', ['username' => 'jan', 'password' => '123456']);

        $this->assertEquals('INSERT INTO sf_links(`username`, `password`) VALUES (\'jan\', \'123456\');', $write->getSql());
    }

    public function testDeleteContext()
    {
        $write = $this->database->getConnection('write');

        $write->delete('sf_links');

        $this->assertEquals('DELETE FROM sf_links;', $write->getSql());

        $write->delete('sf_links', ['username' => 'janhuang']);

        $this->assertEquals('DELETE FROM sf_links WHERE `username`=\'janhuang\';', $write->getSql());

        $write->delete('sf_links', ['AND' => ['username' => 'janhuang', 'password' => '123456']]);

        $this->assertEquals('DELETE FROM sf_links WHERE `username`=\'janhuang\' AND `password`=\'123456\';', $write->getSql());
    }

    public function testCountSelectContext()
    {
        $read = $this->database->getConnection('read');

        $read->count('sf_links');

        $this->assertEquals('SELECT COUNT(1) as total FROM sf_links LIMIT 1;', $read->getSql());

        $read->count('sf_links', ['username' => 'janhuang']);

        $this->assertEquals('SELECT COUNT(1) as total FROM sf_links WHERE `username`=\'janhuang\' LIMIT 1;', $read->getSql());
    }
}