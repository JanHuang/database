<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 16/1/4
 * Time: 下午10:34
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Database\ORM\Generator;

use FastD\Database\ORM\Parser\TableParser;

/**
 * ORM mapping and builder.
 *
 * Class BuilderAbstract
 *
 * @package FastD\Database\ORM\Generator
 */
abstract class BuilderAbstract
{
    /**
     * @var TableParser
     */
    protected $table;

    /**
     * EntityBuilder constructor.
     *
     * @param TableParser $tableParser
     */
    public function __construct(TableParser $tableParser)
    {
        $this->table = $tableParser;
    }

    /**
     * Parse mapping field type.
     *
     * @param $type
     * @return string
     */
    protected function parseType($type)
    {
        switch (strtolower($type)) {
            case 'varchar':
            case 'char':
            case 'text':
            case 'blod':
                return 'string';
            case 'int':
            case 'tinyint':
            case 'smallint':
            case 'float':
            case 'double':
                return 'int';
        }

        return 'mixed';
    }

    /**
     * Generate entity or repository property.
     *
     * @param        $name
     * @param string $type
     * @param null   $defaultValue
     * @return string
     */
    protected function generateProperty($name, $type = '', $defaultValue = null)
    {
        if (strpos($name, '_')) {
            $arr = explode('_', $name);
            $name = array_shift($arr);
            foreach ($arr as $value) {
                $name .= ucfirst($value);
            }
        }

        $type = $this->parseType($type);

        $value = '';

        if (null !== $defaultValue) {
            $value = ' = \'' . $defaultValue . '\'';
        }

        return  <<<P
    /**
     * @var {$type}
     */
    protected \${$name}{$value};
P;
    }

    /**
     * Generate entity or repository getter and setter.
     *
     * @param        $name
     * @param string $type
     * @return string
     */
    protected function generateGetSetter($name, $type = '')
    {
        if (strpos($name, '_')) {
            $arr = explode('_', $name);
            $name = array_shift($arr);
            foreach ($arr as $value) {
                $name .= ucfirst($value);
            }
        }

        $method = ucfirst($name);

        $type = $this->parseType($type);

        return <<<GS
    /**
     * @param {$type} \${$name}
     * @return \$this
     */
    public function set{$method}(\${$name})
    {
        \$this->{$name} = \${$name};

        return \$this;
    }

    /**
     * @return {$type}
     */
    public function get{$method}()
    {
        return \$this->{$name};
    }
GS;
    }

    abstract public function build();
}