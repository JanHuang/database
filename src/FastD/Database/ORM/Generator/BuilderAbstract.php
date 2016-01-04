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
     * @const int generate autoload.
     */
    const BUILD_PSR4 = 1;

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

    public function parseName($name)
    {

    }

    protected function generateFields($name, $namespace, $dir)
    {
        $class = ucfirst($name) . 'Fields';
        $fields = null !== $this->table->getNewFields() ? $this->table->getNewFields() : $this->table->getFields();
        $list = [];
        $alias = [];
        foreach ($fields as $name => $field) {
            $list[] = [
                'alias'     => $name,
                'name'      => $field->getName(),
                'length'    => $field->getLength(),
                'notnull'   => $field->isNotNull(),
                'unsigned'  => $field->isUnsigned(),
                'default'   => $field->getDefault(),
            ];
            $alias[$field->getName()] = $name;
        }

        $fields = var_export($list, true);
        $alias = var_export($alias, true);

        $namespace = ltrim($namespace . '\\Fields', '\\');

        $primary = $this->generatePrimaryKey();

        $f = <<<F
<?php

namespace {$namespace};

class {$class}
{
    /**
     * @const string
     */
    const PRIMARY = '{$primary}';

    /**
     * Const array
     * @const array
     */
     const FIELDS =
{$fields};

     /**
      * Const fields alias.
      * @const array
      */
     const ALIAS =
{$alias};

}
F;

        if (!is_dir($entityDir = $dir . '/Fields')) {
            mkdir($entityDir, 0755, true);
        }

        file_put_contents($dir . '/Fields/' . $class . '.php', $f);

        return <<<CON

    /**
     * @const string
     */
    const PRIMARY = \\{$namespace}\\{$class}::PRIMARY;

    /**
     * Fields const
     * @const array
     */
    const FIELDS = \\{$namespace}\\{$class}::FIELDS;

    /**
     * Fields alias
     * @const array
     */
    const ALIAS = \\{$namespace}\\{$class}::ALIAS;
CON
;
    }

    protected function generatePrimaryKey()
    {
        return $this->table->getPrimary();
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

        return <<<P

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
     * set{$method}
     *
     * @param {$type} \${$name}
     * @return \$this
     */
    public function set{$method}(\${$name})
    {
        \$this->{$name} = \${$name};

        return \$this;
    }

    /**
     * get{$method}
     *
     * @return {$type}
     */
    public function get{$method}()
    {
        return \$this->{$name};
    }
GS;
    }

    /**
     * @param $file
     * @return bool
     */
    public function isExists($file)
    {
        return file_exists($file);
    }

    /**
     * @param $name
     * @return string
     */
    public function fetchContent($name)
    {
        if (!class_exists($name)) {
            return '';
        }

        $name = new \ReflectionClass($name);

        return '';
    }

    /**
     * @param     $name
     * @param     $dir
     * @param     $namespace
     * @param int $flag
     * @return mixed
     */
    abstract public function build($name, $dir, $namespace, $flag = BuilderAbstract::BUILD_PSR4);
}