<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 16/2/25
 * Time: 下午5:32
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Database\Schema;

class Table
{
    /**
     * @var string
     */
    protected $table;

    /**
     * @var Field[]
     */
    protected $fields = [];

    /**
     * @var string
     */
    protected $charset = 'utf8';

    /**
     * @var string
     */
    protected $engine = 'InnoDB';

    /**
     * @var string
     */
    protected $comment = '';

    /**
     * @var string
     */
    protected $suffix = '';

    /**
     * @var string
     */
    protected $prefix = '';

    /**
     * @var bool
     */
    protected $force = false;

    /**
     * @var array|mixed
     */
    protected $fieldsCache = [];

    /**
     * @var string
     */
    protected $fieldsCacheFile;

    /**
     * Table constructor.
     * @param string $table
     * @param string $comment
     * @param bool $force
     */
    public function __construct($table, $comment = '', $force = false)
    {
        $this->table = $table;

        $this->force = $force;

        $this->setComment($comment);

        $fieldsCacheDir = __DIR__ . '/fieldsCache';

        $fieldsCacheFile = $fieldsCacheDir . DIRECTORY_SEPARATOR . $this->getFullTableName() . '.cache';

        if (!file_exists($fieldsCacheDir)) {
            mkdir($fieldsCacheDir, 0755, true);
        }

        if (file_exists($fieldsCacheFile)) {
            $this->fieldsCache = include $fieldsCacheFile;
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
     * @param Field $field
     * @param Key $key
     * @return $this
     */
    public function addField(Field $field, Key $key = null)
    {
        if (null !== $key) {
            $field->setKey($key);
        }
        
        $this->fields[$field->getName()] = $field;

        return $this;
    }

    /**
     * @return Field[]
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param $name
     * @return Field|null
     */
    public function getField($name)
    {
        return isset($this->fields[$name]) ? $this->fields[$name] : null;
    }

    /**
     * @return string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * @param string $prefix
     * @return $this
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * @return string
     */
    public function getSuffix()
    {
        return $this->suffix;
    }

    /**
     * @param string $suffix
     * @return $this
     */
    public function setSuffix($suffix)
    {
        $this->suffix = $suffix;

        return $this;
    }

    /**
     * @return string
     */
    public function getEngine()
    {
        return $this->engine;
    }

    /**
     * @param string $engine
     * @return $this
     */
    public function setEngine($engine)
    {
        $this->engine = $engine;

        return $this;
    }

    /**
     * @return string
     */
    public function getCharset()
    {
        return $this->charset;
    }

    /**
     * @param string $charset
     * @return $this
     */
    public function setCharset($charset)
    {
        $this->charset = $charset;

        return $this;
    }

    /**
     * @param $comment
     * @return $this
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @return string
     */
    public function getTableName()
    {
        return $this->table;
    }

    /**
     * @return string
     */
    public function getFullTableName()
    {
        return $this->getPrefix() . $this->getTableName() . $this->getSuffix();
    }

    /**
     * @return int
     */
    protected function saveFieldsCache()
    {
        $fields = [];

        foreach ($this->getFields() as $field) {
            $fields[$field->getName()] = [
                'type'          => $field->getType(),
                'length'        => $field->getLength(),
                'is_unsigned'   => $field->isUnsigned(),
                'is_nullable'   => $field->isNullable(),
                'default'       => $field->getDefault(),
                'comment'       => $field->getComment(),
                'key'           => null === $field->getKey() ? null : $field->getKey()->getKey(),
            ];
        }

        return file_put_contents($this->fieldsCacheFile, '<?php return ' . var_export($fields, true) . ';');
    }

    /**
     * @return array
     */
    protected function getFieldsCache()
    {
        return $this->fieldsCache;
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

        foreach ($this->getFields() as $field) {
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

        $this->saveFieldsCache();

        $schema = $this->isForce() ? ('DROP TABLE IF EXISTS `' . $this->getFullTableName() . '`;' . PHP_EOL . PHP_EOL) : '';
        $schema .= 'CREATE TABLE `' . $this->getFullTableName() . '` (';
        $schema .= PHP_EOL . implode(', ' . PHP_EOL, $fields) . (empty($keys) ? PHP_EOL : (',' . PHP_EOL . implode(', '. PHP_EOL, $keys) . PHP_EOL));
        $schema .= ') ENGINE ' . $this->getEngine() . ' CHARSET ' . $this->getCharset() . ' COMMENT "' . $this->getComment() . '";';

        return $schema;
    }

    public function alter()
    {
        
    }

    /**
     * @return string
     */
    public function drop()
    {
        return 'DROP TABLE IF EXISTS `' . $this->getFullTableName() . '`;';
    }
}