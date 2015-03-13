<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/3/12
 * Time: 上午10:32
 * Github: https://www.github.com/janhuang 
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 */
echo '<pre>';
include __DIR__ . '/../vendor/autoload.php';

use Dobee\Database\DriverManager;

$manager = new DriverManager(array(
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

//$category = $manager->getConnection()->getRepository('Examples:Repository:PostCategory');
$post = $manager->getConnection()->getRepository('Examples:Repository:Post');


//print_r($post->findAllById(1));
//print_r($post->getConnection()->getLastQuery());
//print_r($post->getConnection()->logs());

//print_r($driver);
//print_r($connection->find('sf_post', array('id' => 1)));
//print_r($connection->findAll('sf_post'));
//print_r($connection->createQuery('select * from sf_post')->getQuery()->getResult());
//print_r($connection->insert('sf_post', array('title' => 'dmemo')));
//print_r($connection->update('sf_post', array('title' => '123'), array('id' => '4')));
//print_r($connection->delete('sf_post', array('id' => 4)));
//var_dump($connection->has('sf_post', array('id' => 4)));
//print_r($connection->count('sf_post'));
print_r($post);
//print_r($post->findAll());
var_dump($post->delete(array('id' => 3)));
print_r($post->findAll());
