<?php
/**
 *
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2016
 *
 * @link      https://www.github.com/janhuang
 * @link      http://www.fast-d.cn/
 */

namespace FastD\Database\Schema;

use FastD\Database\Drivers\DriverInterface;
use FastD\Database\Schema\Structure\Field;
use FastD\Database\Schema\Structure\Key;
use FastD\Database\Schema\Structure\Table;

/**
 * Class SchemaDriver
 * @package FastD\Database\Schema
 */
class SchemaParser extends Schema
{
    /**
     * @var DriverInterface
     */
    protected $driver;

    /**
     * @var Schema[]
     */
    protected $schemas;

    /**
     * SchemaDriver constructor.
     * @param DriverInterface $driverInterface
     */
    public function __construct(DriverInterface $driverInterface)
    {
        $this->driver = $driverInterface;

        $this->reflexTableInDatabase();
    }

    /**
     * @return string
     */
    public function getDbName()
    {
        return $this->driver->getDbName();
    }

    /**
     * @return Schema[]
     */
    public function getSchemas()
    {
        return $this->schemas;
    }

    /**
     * @return SchemaReflex
     */
    public function getSchemaReflex()
    {
        return new SchemaReflex($this->getSchemas());
    }

    /**
     * @param $tables
     */
    protected function reflexTableSchema($tables)
    {
        $config = $this->driver->getConfig();
        $defaultPrefix = isset($config['database_prefix']) ? $config['database_prefix'] : '';
        $defaultSuffix = isset($config['database_suffix']) ? $config['database_suffix'] : '';

        foreach ($tables as $table) {
            $name = array_pop($table);

            if (!empty($defaultPrefix) && false !== ($index = strpos($name, $defaultPrefix))) {
                $len = strlen($defaultPrefix);
                $name = substr($name, $len);
                $prefix = $defaultPrefix;
                unset($len);
            } else {
                $prefix = '';
            }

            if (!empty($defaultSuffix) && false !== ($index = strpos($name, $defaultSuffix))) {
                $name = substr($name, 0, $index);
                $suffix = $defaultSuffix;
            } else {
                $suffix = '';
            }

            $table = new Table($name);
            $table->setPrefix($prefix);
            $table->setSuffix($suffix);
            
            if (!empty(($schemes = $this->parseTableSchema($table->getFullTableName())))) {
                // Parse fields
                foreach ($schemes as $scheme) {
                    $table->addField($this->parseTableSchemaFields($scheme));
                }
                
                $this->schemas[$table->getFullTableName()] = SchemaBuilder::table($table);
            }
        }
    }

    /**
     * @param string $table
     * @return array|bool
     */
    protected function parseTableSchema($table)
    {
        return $this->driver
            ->query(
                'SELECT
  TABLE_SCHEMA AS `db_name`,
  TABLE_NAME AS `table_name`,
  COLUMN_NAME AS `field`,
  COLUMN_DEFAULT AS `default`,
  IS_NULLABLE AS `nullable`,
  COLUMN_TYPE AS `type`,
  COLUMN_COMMENT AS `comment`,
  COLUMN_KEY AS `key`,
  EXTRA AS `extra`
FROM information_schema.COLUMNS
WHERE
  TABLE_NAME = \'' . $table . '\'
  AND TABLE_SCHEMA = \'' . $this->driver->getDbName() . '\';'
            )
            ->execute()
            ->getAll();
    }

    /**
     * @param $schema
     * @return Field
     */
    protected function parseTableSchemaFields($schema)
    {
        $type = $schema['type'];
        $pattern = '/(?<type>\w+)\(?(?<length>\d*)\)?\s?(?<unsigned>\w*)?/';
        preg_match($pattern, $type, $match);

        $field = new Field(
            $schema['field'],
            $match['type'],
            (int) $match['length'],
            $schema['nullable'] == 'NO' ? false : true,
            $schema['default'],
            $schema['comment']
        );

        $field->setUnsigned('unsigned' === trim($match['unsigned']) ? true : false);

        switch ($schema['extra']) {
            case 'auto_increment':
                $field->setIncrement();
                break;
        }

        switch ($schema['key']) {
            case 'PRI':
                $field->setKey(new Key(Key::PRIMARY));
                break;
            case 'MUL':
                $field->setKey(new Key(Key::INDEX));
                break;
            case 'UNI':
                $field->setKey(new Key(Key::UNIQUE));
                break;
        }

        return $field;
    }

    /**
     * @return void
     */
    protected function reflexTableInDatabase()
    {
        $tables = $this->driver
            ->query('SHOW TABLES;')
            ->execute()
            ->getAll();

        $this->reflexTableSchema($tables);
    }
}