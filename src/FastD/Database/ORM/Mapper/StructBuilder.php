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

namespace FastD\Database\ORM\Mapper;

/**
 * Class Struct
 *
 * @package FastD\Database\ORM
 */
class StructBuilder
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
     * @var FieldBuilder|null
     */
    protected $primary;

    /**
     * @var FieldBuilder[]|array
     */
    protected $fileds = [];

    /**
     * @param $struct
     */
    public function __construct($struct)
    {
        $this->struct   = $struct;

        $this->table    = isset($struct['table']) ? $struct['table'] : null;

        $this->suffix   = isset($struct['suffix']) ? $struct['suffix'] : null;

        $this->prefix   = isset($struct['prefix']) ? $struct['prefix'] : null;

        $this->cache    = isset($struct['cache']) ? $struct['cache'] : null;

        $this->engine   = isset($struct['engine']) ? $struct['engine'] : null;

        $this->charset  = isset($struct['charset']) ? $struct['charset'] : null;

        if (isset($struct['fields']) && is_array($struct['fields'])) {
            foreach ($struct['fields'] as $key => $value) {
                if (!is_array($value)) {
                    break;
                }
                if (isset($value['primary']) && true === $value['primary']) {
                    $this->primary = new FieldBuilder($value, $key);
                }

                $this->fields[] = new FieldBuilder($value, $key);
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
     * @return FieldBuilder[]
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @return array|FieldBuilder[]
     */
    public function getFileds()
    {
        return $this->fileds;
    }

    /**
     * @return FieldBuilder|null
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
        $sql = <<<T
CREATE TABLE `%s` (
%s
) DEFAULT CHARSET=%s ENGINE=%s;
T;

        $indexKey = [];
        $fields = [];

        foreach ($this->getFields() as $field) {
            if ($field->isPrimary()) {
                $indexKey[] = "PRIMARY KEY (`{$this->primary->getName()}`)";
            } else if ('' != ($key = $field->getKey())) {
                $indexKey[] = $field->getKey();
            }

            $fields[] = $field->__toString();
        }

        $sql = sprintf(
            $sql,
            $this->getTable(),
            implode(',' . PHP_EOL, $fields) . ',' . PHP_EOL . implode(',' . PHP_EOL, $indexKey),
            $this->getCharset(),
            $this->getEngine()
        );

        return $sql;
    }
}