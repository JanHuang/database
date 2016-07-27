<?php
/**
 *
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2016
 *
 * @link      https://www.github.com/janhuang
 * @link      http://www.fast-d.cn/
 */

namespace Database\Tests\Schema;

use FastD\Database\Schema\SchemaParser;
use FastD\Database\Drivers\MySQLDriver;
use Tests\Fixture_Database_TestCast;

class SchemaParserTest extends Fixture_Database_TestCast
{
    const CONNECTION = [
        'database_host'      => '127.0.0.1',
        'database_port'      => '3306',
        'database_name'      => 'dbunit',
        'database_user'      => 'root',
        'database_pwd'       => '123456',
        'database_prefix'    => 'fd_'
    ];

    public function testTableSchemaReflexRename()
    {
        $driver = new MySQLDriver(self::CONNECTION);

        /*$schemaDriver = new SchemaParser($driver);

        $schemaDriver->getSchemaReflex()->reflex(
            __DIR__ . '/Reflex/Rename/' . $driver->getDbName(),
            'Test\\Rename\\' . $driver->getDbName()
        );*/
    }

    public function testTableSchemaReflex()
    {
        $driver = new MySQLDriver(parent::CONNECTION);

        $schemaDriver = new SchemaParser($driver);

        $schemaDriver->getSchemaReflex()->reflex(
            __DIR__ . '/Reflex/' . ucfirst($driver->getDbName()),
            'Test\\' . $driver->getDbName()
        );
    }
}
