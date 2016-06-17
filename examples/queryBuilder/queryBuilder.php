<?php
/**
 *
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2016
 *
 * @link      https://www.github.com/janhuang
 * @link      http://www.fast-d.cn/
 */

include __DIR__ . '/../../vendor/autoload.php';

use FastD\Database\Query\MySQLQueryBuilder;

$queryBuilder = new MySQLQueryBuilder();

echo $queryBuilder->from('test')->select(); // SELECT * FROM `test`;
