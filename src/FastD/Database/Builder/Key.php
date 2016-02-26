<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 16/2/26
 * Time: 上午12:02
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Database\Builder;

/**
 * Class Key
 *
 * @package FastD\Database\Builder
 */
class Key extends Builder
{
    const KEY_PRIMARY = 1;
    const KEY_UNIQUE = 2;
    const KEY_INDEX = 3;
    const KEY_FULLTEXT = 4;

    /**
     * @var string
     */
    protected $field;

    /**
     * @var int
     */
    protected $type;

    /**
     * Key constructor.
     * @param null $field
     * @param int $type
     */
    public function __construct($field = null, $type = self::KEY_INDEX)
    {
        $this->field = $field;

        $this->type = $type;
    }

    /**
     * @param $field
     * @return $this
     */
    public function setField($field)
    {
        $this->field = $field;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @param int $type
     * @return $this
     */
    public function setType($type = self::KEY_INDEX)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        switch ($this->type) {
            case self::KEY_PRIMARY:
                return 'PRIMARY';
            case self::KEY_INDEX:
                return 'INDEX';
            case self::KEY_UNIQUE;
                return 'UNIQUE';
            case self::KEY_FULLTEXT:
                return 'FULLTEXT';
        }

        throw new \InvalidArgumentException(sprintf('Key ["%s"] is undefined.', $this->type));
    }

    /**
     * @return bool
     */
    public function isPrimary()
    {
        return $this->type === self::KEY_PRIMARY;
    }

    /**
     * @return bool
     */
    public function isUnique()
    {
        return $this->type === self::KEY_UNIQUE;
    }

    /**
     * @return bool
     */
    public function isIndex()
    {
        return $this->type === self::KEY_INDEX;
    }

    /**
     * @return bool
     */
    public function isFullText()
    {
        return $this->type === self::KEY_FULLTEXT;
    }

    /**
     * @param null|int $flag
     * @return string
     */
    public function toSql($flag = Field::FIELD_CREATE)
    {
        $key = strtolower($this->getKey() . '_' . $this->getField());

        switch ($flag) {
            case Field::FIELD_CREATE:
                if ($this->isPrimary()) {
                    return "{$this->getKey()} KEY (`{$this->getField()}`)";
                } else if ($this->isUnique()) {
                    return "{$this->getKey()} KEY `{$key}` (`{$this->getField()}`)";
                } else {
                    return "KEY `{$key}` (`{$this->getField()}`)";
                }
            case Field::FIELD_CHANGE:
            case Field::FIELD_ADD:
                if ($this->isPrimary()) {
                    return "ADD {$this->getKey()} KEY (`{$this->getField()}`)";
                }
                return "ADD {$this->getKey()} `{$key}` (`{$this->getField()}`)";
            case Field::FIELD_DROP:
                if ($this->isPrimary()) {
                    return "DROP PRIMARY KEY";
                }
                return "DROP INDEX `{$key}`";
        }

        throw new \InvalidArgumentException(sprintf('Key ["%s"] is undefined.', $this->type));
    }

    /**
     * @param null|int $flag
     * @return string
     */
    public function toYml($flag = null)
    {
        return '';
    }
}