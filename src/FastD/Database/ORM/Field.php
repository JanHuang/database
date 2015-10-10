<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/10/11
 * Time: 上午1:45
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Database\ORM;

/**
 * Class Field
 *
 * @package FastD\Database\ORM
 */
class Field
{
    /**
     * @var null
     */
    protected $name;

    /**
     * @var null
     */
    protected $type;

    /**
     * @var int
     */
    protected $length = 0;

    /**
     * @var string
     */
    protected $default = '';

    /**
     * @var string
     */
    protected $comment = '';

    /**
     * @var int
     */
    protected $increment = 1;

    /**
     * @var bool
     */
    protected $unsigned = false;

    /**
     * @var bool|null
     */
    protected $index = null;

    /**
     * @var bool
     */
    protected $notnull = true;

    /**
     * @param array $field
     * @param string $name
     */
    public function __construct(array $field, $name = '')
    {
        $this->name = isset($field['name']) ? $field['name'] : $this->parseName($name);

        $this->type = isset($field['type']) ? $field['type'] : null;

        $this->length = isset($field['length']) ? $field['length'] : 0;

        $this->default = isset($field['default']) ? $field['default'] : '';

        $this->comment = isset($field['comment']) ? $field['comment'] : '';

        $this->increment = isset($field['increment']) ? $field['increment'] : 1;

        $this->unsigned = isset($field['unsigned']) ? $field['unsigned'] : false;

        $this->index = isset($field['index']) ? $field['index'] : false;
        
        $this->notnull = isset($field['notnull']) ? $field['notnull'] : true;
    }

    /**
     * @return null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return null
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @return string
     */
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @return int
     */
    public function getIncrement()
    {
        return $this->increment;
    }

    /**
     * @return boolean
     */
    public function isUnsigned()
    {
        return $this->unsigned;
    }

    /**
     * @return bool|null
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * @return boolean
     */
    public function isNotnull()
    {
        return $this->notnull;
    }

    public function parseName($name)
    {
        return $name;
    }
}