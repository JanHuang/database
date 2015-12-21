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
     * FieldParser constructor.
     *
     * @param array $field
     */
    public function __construct(array $field)
    {
        if (isset($field['Type'])) {
            $this->parseExistsField($field);
        } else {
            $this->parseCreateField($field);
        }
    }

    protected function parseExistsField(array $field)
    {
        preg_match('/^(\w+)+\(?(\d+)\)\s?(.*)/', $field['Type'], $match);
        $this->type = $match[1];
        $this->length = $match[2];
        $this->unsigned = 'unsigned' === $match[3] ? true : false;
        unset($match);

        $this->key = $field['Key'];
        $this->default = $field['Default'];
        $this->extra = $field['Extra'];
        $this->notNull = 'NO' === $field['Null'] ? true : false;
        $this->primary = 'PRI' === $field['Key'] ? true : false;
        $this->unique = 'UNI' === $field['Key'] ? true : false;
        $this->index = 'MUL' === $field['Key'] ? true : false;

        $this->name = $field['Field'];
    }

    protected function parseCreateField(array $field)
    {
        $this->name = $field['name'];
        $this->type = $field['type'];
        $this->length = isset($field['length']) ? $field['length'] : null;
        $this->default = isset($field['default']) ? $field['default'] : null;
        $this->comment = isset($field['comment']) ? $field['comment'] : null;
        $this->notNull = isset($field['notnull']) ? $field['notnull'] : false;
        $this->key = isset($field['key']) ? $field['key'] : null;
        $this->unsigned = isset($field['unsigned']) ? $field['unsigned'] : false;
        $this->extra = isset($field['auto_increment']) ? $field['auto_increment'] : null;
        $this->primary = 'PRI' === $this->key ? true : false;
        $this->unique = 'UNI' === $this->key ? true : false;
        $this->index = 'MUL' === $this->key ? true : false;
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

    public function makeAlterSQL(TableParser $tableParser, $isChange = false)
    {
        return !$isChange ?
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

    public function makeCreateSQL(TableParser $tableParser)
    {

    }

    public function makeIndexSQL(TableParser $tableParser)
    {

    }
}