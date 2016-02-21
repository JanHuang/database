<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/12/20
 * Time: 上午10:58
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Database\ORM\Parser;

/**
 * Class FieldParser
 *
 * @package FastD\Database\ORM\Parser
 */
class FieldParser
{
    /**
     * @var string
     */
    protected $key;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var int
     */
    protected $length;

    /**
     * @var bool
     */
    protected $unsigned = false;

    /**
     * @var string
     */
    protected $default = null;

    /**
     * @var bool
     */
    protected $notNull = false;

    /**
     * @var string
     */
    protected $extra = [];

    /**
     * @var string
     */
    protected $comment = null;

    /**
     * @var bool
     */
    protected $primary = false;

    /**
     * @var bool
     */
    protected $unique = false;

    /**
     * @var bool
     */
    protected $index = false;

    /**
     * @var bool
     */
    protected $exists = false;

    /**
     * FieldParser constructor.
     *
     * @param array $field
     * @param bool $isExists
     * @param bool $flag
     */
    public function __construct(array $field, $isExists = false, $flag = false)
    {
        $this->exists = $isExists;

        if ($this->isExists() && !$flag) {
            $this->parseExistsField($field);
        } else {
            $this->parseNotExistsField($field);
        }
    }

    /**
     * @param $name
     * @return string
     */
    protected function getKeyIndexName($name)
    {
        switch ($name) {
            case 'UNI':
                return 'unique';
            case 'PRI':
                return 'primary';
            case 'MUL':
                return 'index';
            default:
                return $name;
        }
    }

    /**
     * @param array $field
     */
    protected function parseExistsField(array $field)
    {
        preg_match('/^(\w+)+\(?(\d+)\)\s?(.*)/', $field['Type'], $match);
        if (!empty($match)) {
            $this->type = $match[1];
            $this->length = $match[2];
            $this->unsigned = 'unsigned' === $match[3] ? true : false;
            unset($match);
        } else {
            $this->type = $field['Type'];
            $this->length = null;
        }

        $this->key = $this->getKeyIndexName($field['Key']);
        $this->default = $field['Default'];
        $this->extra = $field['Extra'];
        $this->notNull = 'NO' === $field['Null'] ? true : false;
        $this->primary = 'primary' === $this->key ? true : false;
        $this->unique = 'unique' === $this->key ? true : false;
        $this->index = 'index' === $this->key ? true : false;

        $this->name = $field['Field'];
    }

    /**
     * @param array $field
     */
    protected function parseNotExistsField(array $field)
    {
        switch ($field['type']) {
            case 'array':
            case 'json':
                $type = 'varchar';
                break;
            default:
                $type = $field['type'];
        }
        $this->name = $field['name'];
        $this->type = $type;
        $this->length = isset($field['length']) ? $field['length'] : null;
        $this->default = isset($field['default']) ? $field['default'] : null;
        $this->comment = isset($field['comment']) ? $field['comment'] : null;
        $this->notNull = isset($field['notnull']) ? $field['notnull'] : false;
        $this->key = isset($field['key']) ? $this->getKeyIndexName($field['key']) : null;
        $this->unsigned = isset($field['unsigned']) ? $field['unsigned'] : false;
        $this->extra = isset($field['auto_increment']) ? $field['auto_increment'] : null;
        $this->primary = 'primary' === $this->key ? true : false;
        $this->unique = 'unique' === $this->key ? true : false;
        $this->index = 'index' === $this->key ? true : false;
    }

    /**
     * @return boolean
     */
    public function isExists()
    {
        return $this->exists;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @return mixed
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return boolean
     */
    public function isUnsigned()
    {
        return $this->unsigned;
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @return null
     */
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * @return boolean
     */
    public function isNotNull()
    {
        return $this->notNull;
    }

    /**
     * @return array
     */
    public function getExtra()
    {
        return $this->extra;
    }

    /**
     * @return boolean
     */
    public function isPrimary()
    {
        return $this->primary;
    }

    /**
     * @return boolean
     */
    public function isUnique()
    {
        return $this->unique;
    }

    /**
     * @return boolean
     */
    public function isIndex()
    {
        return $this->index;
    }

    /**
     * @param TableParser $tableParser
     * @return string
     */
    public function makeAlterSQL(TableParser $tableParser)
    {
        return !$this->isExists() ?
            "ALTER TABLE `{$tableParser->getName()}` ADD `{$this->getName()}` {$this->getType()}" .
            ($this->getLength() > 0 ? "({$this->getLength()})" : '') .
            ($this->isUnsigned() ? " UNSIGNED" : '') .
            ($this->isNotNull() ? " NOT NULL" : '') .
            (null !== $this->getDefault() ? " DEFAULT '{$this->getDefault()}'" : '') .
            (null !== $this->getComment() ? " COMMENT '{$this->getComment()}'" : '') . ';'
            :
            "ALTER TABLE `{$tableParser->getName()}` CHANGE `{$this->getName()}` `{$this->getName()}` {$this->getType()}" .
            ($this->getLength() > 0 ? "({$this->getLength()})" : '') .
            ($this->isUnsigned() ? " UNSIGNED" : '') .
            ($this->isNotNull() ? " NOT NULL" : '') .
            (null !== $this->getDefault() ? " DEFAULT '{$this->getDefault()}'" : '') .
            (null !== $this->getComment() ? " COMMENT '{$this->getComment()}'" : '') . ';'
            ;
    }

    /**
     * @param TableParser $tableParser
     * @return string
     */
    public function makeDropFieldSQL(TableParser $tableParser)
    {
        return "ALTER TABLE `{$tableParser->getName()}` DROP COLUMN `{$this->getName()}`;";
    }

    /**
     * @return string
     */
    public function makeCreateSQL()
    {
        $sql =
            "`{$this->getName()}` {$this->getType()}" .
            ($this->getLength() > 0 ? "({$this->getLength()})" : '') .
            ($this->isUnsigned() ? " UNSIGNED" : '') .
            ($this->isNotNull() ? " NOT NULL" : '') .
            ((null !== $this->getDefault() && !$this->isPrimary()) ? " DEFAULT '{$this->getDefault()}'" : '') .
            (null !== $this->getComment() ? " COMMENT '{$this->getComment()}'" : '')
        ;

        if ($this->isPrimary()) {
            $sql .= ' PRIMARY KEY AUTO_INCREMENT';
        }

        return $sql;
    }

    /**
     * @param TableParser $tableParser
     * @return string
     */
    public function makeAddIndexSQL(TableParser $tableParser)
    {
        if ($this->isPrimary()) {
            $name = 'PRIMARY KEY';
        } else if ($this->isUnique()) {
            $name = 'UNIQUE';
        } else {
            $name = 'INDEX';
        }

        $indexName = str_replace(' ', '_', strtolower($name));

        return "ALTER TABLE `{$tableParser->getName()}` ADD {$name} {$indexName}_{$this->getName()}(`{$this->getName()}`);";
    }

    /**
     * @param TableParser $tableParser
     * @return string
     */
    public function makeDropIndexSQL(TableParser $tableParser)
    {
        if ($this->isPrimary()) {
            $name = 'PRIMARY KEY';
        } else if ($this->isUnique()) {
            $name = 'UNIQUE';
        } else {
            $name = 'INDEX';
        }

        $indexName = str_replace(' ', '_', strtolower($name));

        return "ALTER TABLE `{$tableParser->getName()}` DROP index {$indexName}_{$this->getName()};";
    }

    /**
     * @param FieldParser|null $fieldParser
     * @return bool
     */
    public function equals(FieldParser $fieldParser = null)
    {
        return (string)$this === (string)$fieldParser;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $array = [
            $this->getName(),
            $this->getType(),
            $this->getLength(),
        ];

        if (!$this->isPrimary()) {
            $array[] = $this->getDefault();
        }

        return implode('', $array);
    }
}