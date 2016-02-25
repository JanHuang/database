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

class Key implements BuilderInterface
{
    const KEY_PRIMARY = 1;
    const KEY_UNIQUE = 2;
    const KEY_INDEX = 3;
    const KEY_FULLTEXT = 4;

    protected $field;

    protected $type;

    public function __construct($field, $type = self::KEY_INDEX)
    {
        $this->field = $field;

        $this->type = $type;
    }

    public function getField()
    {
        return $this->field;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getKey()
    {
        switch ($this->type) {
            case self::KEY_PRIMARY:
                return 'primary';
            case self::KEY_INDEX:
                return 'index';
            case self::KEY_UNIQUE;
                return 'unique';
            case self::KEY_FULLTEXT:
                return 'fulltext';
        }

        throw new \InvalidArgumentException(sprintf('Key ["%s"] is undefined.', $this->type));
    }

    public function isPrimary()
    {
        return $this->type === self::KEY_PRIMARY;
    }

    public function isUnique()
    {
        return $this->type === self::KEY_UNIQUE;
    }

    public function isIndex()
    {
        return $this->type === self::KEY_INDEX;
    }

    public function isFullText()
    {
        return $this->type === self::KEY_FULLTEXT;
    }

    /**
     * @param null|int $flag
     * @return string
     */
    public function toSql($flag = null)
    {
        $key = strtolower($this->getKey() . $this->getField());
        switch ($this->type) {
            case self::KEY_PRIMARY:
                return "PRIMARY KEY (`{$this->getField()}`)";
            case self::KEY_INDEX:
                return "KEY `{$key}` (`{$this->getField()}`)";
            case self::KEY_UNIQUE;
                return "UNIQUE KEY `{$key}` (`{$this->getField()}`)";
            case self::KEY_FULLTEXT:
                return 'fulltext';
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