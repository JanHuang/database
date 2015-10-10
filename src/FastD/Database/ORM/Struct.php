<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/10/11
 * Time: 上午1:35
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Database\ORM;

/**
 * Class Struct
 *
 * @package FastD\Database\ORM
 */
class Struct
{
    /**
     * @var array
     */
    protected $struct = [];

    /**
     * @var null
     */
    protected $table;

    /**
     * @var null
     */
    protected $suffix;

    /**
     * @var null
     */
    protected $prefix;

    /**
     * @var null
     */
    protected $repository;

    /**
     * @var null
     */
    protected $cache;

    /**
     * @var null
     */
    protected $engine;

    /**
     * @var null|string
     */
    protected $charset;

    /**
     * @var Field|null
     */
    protected $primary;

    /**
     * @var Field[]|array
     */
    protected $fileds = [];

    /**
     * @param $struct
     */
    public function __construct($struct)
    {
        $this->struct = $struct;

        $this->table = isset($struct['table']) ? $struct['table'] : null;

        $this->suffix = isset($struct['suffix']) ? $struct['suffix'] : null;

        $this->prefix = isset($struct['prefix']) ? $struct['prefix'] : null;

        $this->repository = isset($struct['repository']) ? $struct['repository'] : null;

        $this->cache = isset($struct['cache']) ? $struct['cache'] : null;

        $this->engine = isset($struct['engine']) ? $struct['engine'] : null;

        $this->charset = isset($struct['charset']) ? $struct['charset'] : null;

        $this->primary = isset($struct['primary']) ? new Field($struct['primary']) : null;

        if (isset($struct['fields']) && is_array($struct['fields'])) {
            foreach ($struct['fields'] as $key => $value) {
                if (!is_array($value)) {
                    break;
                }

                $this->fields[] = new Field($value);
            }
        }
    }

    /**
     * @return null
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @return array
     */
    public function getStruct()
    {
        return $this->struct;
    }

    /**
     * @return Field
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @return array|Field[]
     */
    public function getFileds()
    {
        return $this->fileds;
    }

    /**
     * @return Field|null
     */
    public function getPrimary()
    {
        return $this->primary;
    }

    /**
     * @return null|string
     */
    public function getCharset()
    {
        return $this->charset;
    }

    /**
     * @return null
     */
    public function getEngine()
    {
        return $this->engine;
    }

    /**
     * @return null
     */
    public function getCache()
    {
        return $this->cache;
    }

    /**
     * @return null
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * @return null
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * @return null
     */
    public function getSuffix()
    {
        return $this->suffix;
    }

    /**
     * @return string
     */
    public function makeStructSQL()
    {

    }
}