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

/**
 * Mysql Table Schema
 *
 * Class Schema
 *
 * @package FastD\Database\Schema
 */
class Schema
{
    /**
     * @var Table
     */
    protected $table;

    /**
     * @var Field[]
     */
    protected $fieldsCache = [];

    /**
     * @var string
     */
    protected $fieldsCacheFile;

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
        $this->table = $table;

        $this->force = $force;

        $fieldsCacheDir = __DIR__ . '/fieldsCache';

        $fieldsCacheFile = $fieldsCacheDir . DIRECTORY_SEPARATOR . '.table.' . $this->getTable()->getFullTableName() . '.cache';

        if (!file_exists($fieldsCacheDir)) {
            mkdir($fieldsCacheDir, 0755, true);
        }

        if (file_exists($fieldsCacheFile)) {
            try {
                $this->fieldsCache = include $fieldsCacheFile;
                $this->fieldsCache = unserialize($this->fieldsCache);
            } catch (\Exception $e) {
                $this->fieldsCache = [];
            }
        }

        $this->fieldsCacheFile = $fieldsCacheFile;

        unset($fieldsCacheDir, $fieldsCacheFile);
    }

    /**
     * @return bool
     */
    public function isForce()
    {
        return $this->force;
    }

    /**
     * @return Table
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @return void
     */
    protected function clearFieldsCache()
    {
        if (file_exists($this->fieldsCacheFile)) {
            unlink($this->fieldsCacheFile);
        }
    }

    /**
     * @return int
     */
    protected function saveFieldsCache()
    {
        return file_put_contents($this->fieldsCacheFile, '<?php return ' . var_export(serialize($this->getTable()->getFields()), true) . ';');
    }

    /**
     * @return Field[]
     */
    protected function getFieldsCache()
    {
        return $this->fieldsCache;
    }

    /**
     * @param Field[] $fields
     * @return \stdClass
     */
    protected function diff(array $fields)
    {
        $cache = $this->getFieldsCache();

        $add = [];
        $alter = [];
        $drop = [];

        foreach ($fields as $name => $field) {
            // Not in cache.
            if (!array_key_exists($name, $cache)) {
                $add[$name] = $field;
            } else {
                if (!$cache[$name]->equal($field)) {
                    $alter[$name] = $field;
                }
            }
        }

        foreach ($cache as $name => $field) {
            if (!array_key_exists($name, $fields)) {
                $drop[$name] = $field;
            }
        }

        print_r($add);
        print_r($alter);
        print_r($drop);
        die;

        // Return anonymous fields class.
        return new class ($add, $alter, $drop) {
            protected $add;
            protected $alter;
            protected $drop;
            public function __construct($add, $alter, $drop)
            {
                $this->add = $add;

                $this->alter = $alter;

                $this->drop = $drop;
            }

            public function getAddFields()
            {
                return $this->add;
            }

            public function getAlterFields()
            {
                return $this->alter;
            }

            public function getDropFields()
            {
                return $this->drop;
            }
        };
    }

    /**
     * @param Table $table
     * @return Schema
     */
    public static function table(Table $table)
    {
        return new static($table);
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

        foreach ($this->getTable()->getFields() as $field) {
            $fields[] = implode(' ', [
                '`' . $field->getName() . '`',
                $field->getType() . '(' . $field->getLength() . ')',
                ($field->isUnsigned()) ? 'UNSIGNED' : '',
                ($field->isNullable() ? '' : ('NOT NULL DEFAULT "' . $field->getDefault() . '"')),
                ($field->isPrimary()) ? 'AUTO_INCREMENT' : '',
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
        }

        $schema = $this->isForce() ? ('DROP TABLE IF EXISTS `' . $this->getFullTableName() . '`;' . PHP_EOL . PHP_EOL) : '';
        $schema .= 'CREATE TABLE `' . $this->getFullTableName() . '` (';
        $schema .= PHP_EOL . implode(', ' . PHP_EOL, $fields) . (empty($keys) ? PHP_EOL : (',' . PHP_EOL . implode(', ' . PHP_EOL, $keys) . PHP_EOL));
        $schema .= ') ENGINE ' . $this->getEngine() . ' CHARSET ' . $this->getCharset() . ' COMMENT "' . $this->getComment() . '";';

        $this->saveFieldsCache();

        return $schema;
    }

    /**
     * Alter table.
     *
     * @return string
     */
    public function alter()
    {
        $add = [];
        $change = [];
        $drop = [];
        $keys = [];

        $cache = $this->getFieldsCache();

        $fields = $this->diff($this->getTable()->getFields());

        // Alter table add column.
        foreach ($this->getTable()->getFields() as $field) {
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
                'COMMENT "' . $field->getComment() . '"',
                ';'
            ]);
            if (null !== $field->getKey()) {
                $keys[] = implode(' ', [
                    'ALTER TABLE `' . $this->getTable()->getFullTableName() . '` ADD ' . ($field->getKey()->isPrimary() ? 'PRIMARY KEY' : $field->getKey()->getKey()),
                    '`index_' . $field->getName() . '` (' . $field->getName() . ')',
                    ';'
                ]);
            }
        }

        // Alter table change column.
        foreach ($this->getTable()->getAlterFields() as $name => $field) {
            if (!array_key_exists($name, $cache)) {
                continue;
            }
            $change[] = implode(' ', [
                'ALTER TABLE `' . $this->getTable()->getFullTableName() . '` CHANGE `' . $name . '` `' . $field->getName() . '`',
                $field->getType() . '(' . $field->getLength() . ')',
                ($field->isUnsigned()) ? 'UNSIGNED' : '',
                ($field->isNullable() ? '' : ('NOT NULL DEFAULT "' . $field->getDefault() . '"')),
                ($field->isPrimary()) ? 'AUTO_INCREMENT' : '',
                'COMMENT "' . $field->getComment() . '"',
                ';'
            ]);
        }

        // Alter table drop column and drop map key.
        foreach ($this->getTable()->getDropFields() as $field) {
            $drop[] = implode(' ', [
                'ALTER TABLE `' . $this->getTable()->getFullTableName() . '`',
                'DROP `' . $field . '`',
                ';'
            ]);
        }

        $this->saveFieldsCache();

        return implode(PHP_EOL, [
            implode(PHP_EOL, $add),
            implode(PHP_EOL, $change),
            implode(PHP_EOL, $drop),
            implode(PHP_EOL, $keys),
        ]);
    }

    /**
     * Drop table.
     *
     * @return string
     */
    public function drop()
    {
        $this->clearFieldsCache();

        return 'DROP TABLE IF EXISTS `' . $this->getTable()->getFullTableName() . '`;';
    }
}