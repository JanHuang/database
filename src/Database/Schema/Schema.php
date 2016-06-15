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

use FastD\Database\Schema\Structure\Table;

/**
 * Mysql Table Schema
 *
 * Class Schema
 *
 * @package FastD\Database\Schema
 */
class Schema extends SchemaCache
{
    /**
     * @var bool
     */
    protected $force = false;

    /**
     * Schema constructor.
     *
     * @param Table $table
     * @param bool $force
     */
    public function __construct(Table $table, $force = false)
    {
        $this->force = $force;

        parent::__construct($table);
    }

    /**
     * @return bool
     */
    public function isForce()
    {
        return $this->force;
    }

    /**
     * @param Table $table
     * @param bool $force
     * @return Schema
     */
    public static function table(Table $table, $force = false)
    {
        return new static($table, $force);
    }

    /**
     * Return table create schema.
     *
     * @return string
     */
    public function create()
    {
        $fields = [];
        $keys = [];

        foreach ($this->getTable()->getFields() as $name => $field) {
            $fields[] = implode(' ', [
                '`' . $field->getName() . '`',
                $field->getType() . '(' . $field->getLength() . ')',
                ($field->isUnsigned()) ? 'UNSIGNED' : '',
                ($field->isNullable() ? '' : ('NOT NULL DEFAULT "' . $field->getDefault() . '"')),
                ($field->isIncrement()) ? 'AUTO_INCREMENT' : '',
                'COMMENT "' . $field->getComment() . '"'
            ]);

            if (null !== $field->getKey()) {
                if ($field->isPrimary()) {
                    $keys[] = 'PRIMARY KEY (`' . $field->getName() . '`)';
                } else if ($field->isUnique()) {
                    $keys[] = 'UNIQUE KEY `unique_' . $field->getName() . '` (`' . $field->getName() . '`)';
                } else if ($field->isIndex()) {
                    $keys[] = 'KEY `index_' . $field->getName() . '` (`' . $field->getName() . '`)';
                }
            }

            $this->setCacheField($name, $field);
        }

        $schema = $this->isForce() ? ('DROP TABLE IF EXISTS `' . $this->getTable()->getFullTableName() . '`;' . PHP_EOL . PHP_EOL) : '';
        $schema .= 'CREATE TABLE `' . $this->getTable()->getFullTableName() . '` (';
        $schema .= PHP_EOL . implode(',' . PHP_EOL, $fields) . (empty($keys) ? PHP_EOL : (',' . PHP_EOL . implode(',' . PHP_EOL, $keys) . PHP_EOL));
        $schema .= ') ENGINE ' . $this->getTable()->getEngine() . ' CHARSET ' . $this->getTable()->getCharset() . ' COMMENT "' . $this->getTable()->getComment() . '";';

        $this->saveCache();

        return $schema;
    }

    /**
     * Alter table.
     *
     * @return string
     */
    public function update()
    {
        $add = [];
        $change = [];
        $drop = [];
        $keys = [];

        $cache = $this->getCache();

        // Alter table add column.
        foreach ($this->getTable()->getFields() as $name => $field) {
            // ignore add field.
            if (array_key_exists($field->getName(), $cache)) {
                continue;
            }
            $add[] = implode(' ', [
                'ALTER TABLE `' . $this->getTable()->getFullTableName() . '` ADD `' . $field->getName() . '`',
                $field->getType() . '(' . $field->getLength() . ')',
                ($field->isUnsigned()) ? 'UNSIGNED' : '',
                ($field->isNullable() ? '' : ('NOT NULL DEFAULT "' . $field->getDefault() . '"')),
                ($field->isPrimary()) ? 'AUTO_INCREMENT' : '',
                'COMMENT "' . $field->getComment() . '";',
            ]);
            if (null !== $field->getKey()) {
                $keys[] = implode(' ', [
                    'ALTER TABLE `' . $this->getTable()->getFullTableName() . '` ADD ' . ($field->getKey()->isPrimary() ? 'PRIMARY KEY' : $field->getKey()->getKey()),
                    '`index_' . $field->getName() . '` (' . $field->getName() . ');',
                ]);
            }

            $this->setCacheField($name, $field);
        }

        // Alter table change column.
        foreach ($this->getTable()->getAlterFields() as $name => $field) {
            if (array_key_exists($name, $cache)) {
                if (!$cache[$name]->equal($field)) {
                    $change[] = implode(' ', [
                        'ALTER TABLE `' . $this->getTable()->getFullTableName() . '` CHANGE `' . $name . '` `' . $field->getName() . '`',
                        $field->getType() . '(' . $field->getLength() . ')',
                        ($field->isUnsigned()) ? 'UNSIGNED' : '',
                        ($field->isNullable() ? '' : ('NOT NULL DEFAULT "' . $field->getDefault() . '"')),
                        ($field->isPrimary()) ? 'AUTO_INCREMENT' : '',
                        'COMMENT "' . $field->getComment() . '";',
                    ]);
                    if (null !== $field->getKey()) {
                        $keys[] = implode(' ', [
                            'ALTER TABLE `' . $this->getTable()->getFullTableName() . '` ADD ' . ($field->getKey()->isPrimary() ? 'PRIMARY KEY' : $field->getKey()->getKey()),
                            '`index_' . $field->getName() . '` (' . $field->getName() . ');',
                        ]);
                    }

                    $this->setCacheField($name, $field);
                }
            }
        }

        // Alter table drop column and drop map key.
        foreach ($this->getTable()->getDropFields() as $name => $field) {
            if (!array_key_exists($name, $cache)) {
                continue;
            }
            $drop[] = implode(' ', [
                'ALTER TABLE `' . $this->getTable()->getFullTableName() . '`',
                'DROP `' . $field . '`;',
            ]);

            $this->unsetCacheField($name);
        }

        $this->saveCache();

        // Sync table and cache field.
        $this->getTable()->setFields($this->fieldsCache);
        
        return implode(PHP_EOL, array_filter([
            implode(PHP_EOL, $add),
            implode(PHP_EOL, $change),
            implode(PHP_EOL, $drop),
            implode(PHP_EOL, $keys),
        ]));
    }

    /**
     * Drop table.
     *
     * @return string
     */
    public function drop()
    {
        $this->clearCache();

        return 'DROP TABLE ' . ($this->isForce() ? 'IF EXISTS ' : '') . '`' . $this->getTable()->getFullTableName() . '`;';
    }
}