<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/6/18
 * Time: 下午10:45
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */


namespace FastD\Database\Tests;


use FastD\Database\Query\QueryContext;

class MysqlContextTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var QueryContext
     */
    protected $context;

    public function setUp()
    {
        $this->context = new QueryContext();
    }

    public function testFind()
    {
        $this->assertEquals('SELECT `username` FROM `ws_user`;', $this->context->table('ws_user')->fields(['username'])->select()->getSql());
        $this->assertEquals('SELECT `username`,`password` FROM `ws_user`;', $this->context->table('ws_user')->fields(['username', 'password'])->select()->getSql());
        $this->assertEquals('SELECT * FROM `ws_user`;', $this->context->table('ws_user')->select()->getSql());
        $this->assertEquals('SELECT * FROM `ws_user` LIMIT 1;', $this->context->table('ws_user')->limit(1)->select()->getSql());
        $this->assertEquals('SELECT * FROM `ws_user` LIMIT 0,1;', $this->context->table('ws_user')->limit(1, 0)->select()->getSql());
        $this->assertEquals('SELECT * FROM `ws_user` WHERE `username`=\'janhuang\';', $this->context->table('ws_user')->where(['username' => 'janhuang'])->select()->getSql());
        $this->assertEquals('SELECT * FROM `ws_user` WHERE `username`=\'janhuang\' AND `password`=\'123456\';', $this->context->table('ws_user')->where(['AND' => ['username' => 'janhuang','password' => '123456']])->select()->getSql());
        $this->assertEquals('SELECT * FROM `ws_user` GROUP BY id;', $this->context->table('ws_user')->group('id')->select()->getSql());
        $this->assertEquals('SELECT * FROM `ws_user` ORDER BY id;', $this->context->table('ws_user')->order('id')->select()->getSql());
        $this->assertEquals('SELECT * FROM `ws_user` GROUP BY id ORDER BY id;', $this->context->table('ws_user')->group('id')->order('id')->select()->getSql());
        $this->assertEquals('SELECT * FROM `ws_user` GROUP BY id HAVING `id` > 2;', $this->context->table('ws_user')->group('id')->having(['id' => ' > 2'])->select()->getSql());
    }

    public function testInsert()
    {
        $this->assertEquals('INSERT INTO `ws_user`(`username`) VALUES (\'janhuang\');', $this->context->table('ws_user')->data(['username' => 'janhuang'], QueryContext::CONTEXT_INSERT)->insert()->getSql());
        $this->assertEquals('INSERT INTO `ws_user`(`username`,`password`) VALUES (\'janhuang\',\'123456\');', $this->context->table('ws_user')->data(['username' => 'janhuang', 'password' => '123456'], QueryContext::CONTEXT_INSERT)->insert()->getSql());
    }

    public function testUpdate()
    {
        $this->assertEquals('UPDATE `ws_user` SET `username`=\'janhuang\';', $this->context->table('ws_user')->data(['username' => 'janhuang'], QueryContext::CONTEXT_UPDATE)->update()->getSql());
        $this->assertEquals('UPDATE `ws_user` SET `username`=\'janhuang\' LIMIT 1;', $this->context->table('ws_user')->limit(1)->data(['username' => 'janhuang'], QueryContext::CONTEXT_UPDATE)->update()->getSql());
        $this->assertEquals('UPDATE `ws_user` SET `username`=\'janhuang\' WHERE `id`=\'1\';', $this->context->table('ws_user')->data(['username' => 'janhuang'], QueryContext::CONTEXT_UPDATE)->where(['id' => 1])->update()->getSql());
        $this->assertEquals('UPDATE `ws_user` SET `username`=\'janhuang\' WHERE `id`=\'1\' OR `username`=\'jan\';', $this->context->table('ws_user')->data(['username' => 'janhuang'], QueryContext::CONTEXT_UPDATE)->where(['OR' => ['id' => 1, 'username' => 'jan']])->update()->getSql());
        $this->assertEquals('UPDATE `ws_user` SET `username`=\'janhuang\',`password`=\'123456\';', $this->context->table('ws_user')->data(['username' => 'janhuang', 'password' => '123456'], QueryContext::CONTEXT_UPDATE)->update()->getSql());
    }

    public function testDelete()
    {
        $this->assertEquals('DELETE FROM `test`.`ws_user`;', $this->context->table('`test`.`ws_user`')->delete()->getSql());
        $this->assertEquals('DELETE FROM `ws_user` WHERE `username`=\'janhuang\';', $this->context->table('ws_user')->where(['username'=>'janhuang'])->delete()->getSql());
        $this->assertEquals('DELETE FROM `ws_user` WHERE `username`=\'janhuang\' LIMIT 1;', $this->context->table('ws_user')->where(['username'=>'janhuang'])->limit(1)->delete()->getSql());
        $this->assertEquals('DELETE FROM `ws_user` WHERE `username`=\'janhuang\' AND `password`=\'123456\';', $this->context->table('ws_user')->where(['AND' => ['username'=>'janhuang', 'password'=>'123456']])->delete()->getSql());
    }
}