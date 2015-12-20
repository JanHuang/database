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
        print_r($field);
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
}