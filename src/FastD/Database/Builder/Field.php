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

namespace FastD\Database\Builder;

/**
 * Class Field
 *
 * @package FastD\Database\Builder
 */
class Field extends Builder
{
    const FIELD_ADD = 1;
    const FIELD_CHANGE = 2;
    const FIELD_DROP = 3;
    const FIELD_CREATE = 4;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $alias;

    /**
     * @var int
     */
    protected $length;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var bool
     */
    protected $unsigned = false;

    /**
     * @var bool
     */
    protected $nullable = false;

    /**
     * @var string
     */
    protected $default;

    /**
     * @var string
     */
    protected $extra;

    /**
     * @var string
     */
    protected $comment;

    /**
     * @var Key
     */
    protected $key;

    /**
     * @var Field
     */
    protected $to_change;

    /**
     * Field constructor.
     * @param $name
     * @param $type
     * @param $length
     * @param $alias
     * @param bool $nullable
     * @param string $default
     * @param string $comment
     */
    public function __construct(
        $name,
        $type,
        $length,
        $alias = '',
        $nullable = false,
        $default = '',
        $comment = ''
    )
    {
        $this->name = $name;

        if (in_array($type, ['array'])) {
            $type = 'varchar';
        }

        if (in_array($type, [
            'int',
            'smallint',
            'tinyint',
            'mediumint',
            'integer',
            'bigint',
            'float',
            'double'])) {
            $default = 0;
        }

        $this->type = $type;

        $this->length = $length;

        $this->alias = $alias;

        $this->nullable = $nullable;

        $this->default = $default;

        $this->comment = $comment;
    }

    /**
     * @return int
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @param int $length
     * @return $this
     */
    public function setLength($length)
    {
        $this->length = $length;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isUnsigned()
    {
        return $this->unsigned;
    }

    /**
     * @param boolean $unsigned
     * @return $this
     */
    public function setUnsigned($unsigned)
    {
        $this->unsigned = $unsigned;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isNullable()
    {
        return $this->nullable;
    }

    /**
     * @param boolean $nullable
     * @return $this
     */
    public function setNullable($nullable)
    {
        $this->nullable = $nullable;

        return $this;
    }

    /**
     * @return string
     */
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * @param string $default
     * @return $this
     */
    public function setDefault($default)
    {
        $this->default = $default;

        return $this;
    }

    /**
     * @return string
     */
    public function getExtra()
    {
        return $this->extra;
    }

    /**
     * @param string $extra
     * @return $this
     */
    public function setExtra($extra)
    {
        $this->extra = $extra;

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
     * @param string $comment
     * @return $this
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * @return Key
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param Key $key
     * @return $this
     */
    public function setKey(Key $key)
    {
        $this->key = $key;

        $key->setField($this->getName());

        return $this;
    }

    /**
     * @return string
     */
    public function getAlias()
    {
        return empty($this->alias) ? $this->rename($this->name) : $this->alias;
    }

    /**
     * @param string $alias
     * @return $this
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isPrimary()
    {
        if (null === $this->key) {
            return false;
        }

        return $this->key->isPrimary();
    }

    /**
     * @return $this
     */
    public function setPrimary()
    {
        $this->key->setType(Key::KEY_PRIMARY);

        return $this;
    }

    /**
     * @return boolean
     */
    public function isUnique()
    {
        if (null === $this->key) {
            return false;
        }

        return $this->key->isUnique();
    }

    /**
     * @return $this
     */
    public function setUnique()
    {
        $this->key->setType(Key::KEY_UNIQUE);

        return $this;
    }

    /**
     * @return boolean
     */
    public function isIndex()
    {
        if (null === $this->key) {
            return false;
        }

        return $this->key->isIndex();
    }

    /**
     * @return $this
     */
    public function setIndex()
    {
        $this->key->setType(Key::KEY_INDEX);

        return $this;
    }

    /**
     * @param Field $field
     * @return $this
     */
    public function changeTo(Field $field)
    {
        $this->to_change = $field;

        return $this;
    }

    /**
     * @param int $flag
     * @return string
     */
    public function toSql($flag = self::FIELD_CREATE)
    {
        $length = $this->getLength() ? '(' . $this->getLength() . ')' : '';
        $unsigned = $this->isUnsigned() ? ' unsigned ' : '';
        $nullable = $this->isNullable() ? '' : ' NOT NULL';
        $default = '';
        if (!$this->isNullable() && !$this->isPrimary()) {
            if (is_integer($this->getDefault())) {
                $default = ' DEFAULT ' . $this->getDefault();
            } else {
                $default = $this->getDefault() ? ' DEFAULT \'' . $this->getDefault() . '\'' : ' DEFAULT \'\'';
            }
        }
        $comment = $this->getComment() ? ' COMMENT \'' . $this->getComment() . '\'' : '';
        $extra = $this->getExtra() ? ' ' . $this->getExtra() : '';
        switch ($flag) {
            case self::FIELD_CREATE:
                return "`{$this->getName()}` {$this->getType()}{$length}{$unsigned}{$nullable}{$default}{$comment}{$extra}";
            case self::FIELD_ADD:
                return "ADD `{$this->getName()}` {$this->getType()}{$length}{$unsigned}{$nullable}{$default}{$comment}";
            case self::FIELD_CHANGE:
                if (null !== $this->to_change) {
                    $length = $this->to_change->getLength() ? '(' . $this->to_change->getLength() . ')' : '';
                    $unsigned = $this->to_change->isUnsigned() ? ' unsigned ' : '';
                    $nullable = $this->to_change->isNullable() ? '' : ' NOT NULL';
                    $default = '';
                    if (!$this->to_change->isNullable() && !$this->isPrimary()) {
                        if (is_integer($this->to_change->getDefault())) {
                            $default = ' DEFAULT ' . $this->to_change->getDefault();
                        } else {
                            $default = $this->to_change->getDefault() ? ' DEFAULT \'' . $this->to_change->getDefault() . '\'' : ' DEFAULT \'\'';
                        }
                    }
                    $comment = $this->to_change->getComment() ? ' COMMENT \'' . $this->to_change->getComment() . '\'' : '';
                    return "CHANGE `{$this->getName()}` `{$this->to_change->getName()}` {$this->to_change->getType()}{$length}{$unsigned}{$nullable}{$default}{$comment}";
                }
                return "CHANGE `{$this->getName()}` `{$this->getName()}` {$this->getType()}{$length}{$unsigned}{$nullable}{$default}{$comment}";
            case self::FIELD_DROP:
                return "DROP `{$this->getName()}`";
            case self::FIELD_INDEX:
                return "";
        }

        throw new \InvalidArgumentException(sprintf('Operation ["%s"] is undefined.', $flag));
    }

    /**
     * @param null $flag
     * @return string
     */
    public function toYml($flag = null)
    {
        return '';
    }
}