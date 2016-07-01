<?php
/**
 * @author: RunnerLee
 * @email: runnerleer@gmail.com
 * @time: 16-7-1 下午4:47
 */
require __DIR__ . '/../vendor/autoload.php';

$table = new \FastD\Database\Schema\Structure\Table('demo');

$id = (new \FastD\Database\Schema\Structure\Field('id', \FastD\Database\Schema\Structure\Field::INT, 11))
        ->setIncrement()->setUnsigned(true);

$username = new \FastD\Database\Schema\Structure\Field('username', \FastD\Database\Schema\Structure\Field::VARCHAR, 255);

$primaryKey = new \FastD\Database\Schema\Structure\Key(\FastD\Database\Schema\Structure\Key::PRIMARY);

$table->addField($id, $primaryKey);

$table->addField($username);

$schemaBuilder = new \FastD\Database\Schema\SchemaBuilder();
$schemaBuilder->addTable($table);

echo "\n";
echo $schemaBuilder->update();
echo "\n";
