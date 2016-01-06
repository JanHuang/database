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

use FastD\Database\ORM\Parser\NameParseTrait;
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
    use NameParseTrait;

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

    /**
     * @param $name
     * @return mixed|string
     */
    public function parseGetSetterName($name)
    {
        return $this->parseName($name);
    }

    /**
     * @param        $name
     * @param string $getset
     * @return string
     */
    public function parseGetSetterMethod($name, $getset = 'set')
    {
        return $getset . ucfirst($this->parseGetSetterName($name));
    }

    /**
     * Reflection defined name;
     *
     * @param string $name Compare class name
     * @return array
     */
    public function compare($name)
    {
        if (!class_exists($name)) {
            return [
                'properties' => [],
                'methods' => [],
            ];
        }

        $class = new \ReflectionClass($name);

        $properties = [];
        // get custom defined properties.
        foreach ($class->getProperties(\ReflectionProperty::IS_PUBLIC | \ReflectionProperty::IS_PROTECTED) as $property) {
            if ($property->getDeclaringClass()->getName() !== $name) {
                continue;
            }

            $property->setAccessible(true);
            $modifier = (function () use ($property) {
                $static = $property->isStatic() ? ' static ' : '';
                $modify = 'public';
                if ($property->isPrivate()) {
                    $modify = 'private';
                }
                if ($property->isProtected()) {
                    $modify = 'protected';
                }
                return $modify . $static;
            })();

            $value = (function () use ($property, $class) {
                return null === $property->getValue($class) ? '' : " = '{$property->getValue($class)}'";
            })();

            $properties[$property->getName()] = <<<P
    {$property->getDocComment()}
    {$modifier} \${$property->getName()}{$value};
P;
        }

        $methods = [];
        // get custom defined methods.
        $file = new \SplFileObject($class->getFileName());
        foreach ($class->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
            if ($method->getDeclaringClass()->getName() !== $name) {
                continue;
            }
            $content = (function () use ($file, $method) {
                $file->seek($method->getStartLine() - 1);
                $length = $method->getEndLine() - $method->getStartLine();
                $i = 0;
                $content = [];
                while ($i <= $length) {
                    $content[] = $file->current();
                    $file->next();
                    $i++;
                }
                return trim(implode('', $content));
            })();
            $content = <<<M
    {$content}
M;
            $docs = rtrim($method->getDocComment());
            if (!empty($docs)) {
                $content = trim($content);
                $content = <<<C
    {$docs}
    {$content}
C;
            }
            $methods[$method->getName()] = PHP_EOL . $content;
        }

        return [
            'properties' => $properties,
            'methods' => $methods
        ];
    }

    /**
     * @param $name
     * @param $namespace
     * @param $dir
     * @return string
     */
    protected function generateFields($name, $namespace, $dir)
    {
        $class = ucfirst($name) . 'Fields';
        $fields = null !== $this->table->getNewFields() ? $this->table->getNewFields() : $this->table->getFields();
        $list = [];
        $alias = [];
        foreach ($fields as $name => $field) {
            $list[$name] = [
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

        $class = $this->parseName($class);

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

    /**
     * @return string
     */
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
        $name = $this->parseGetSetterName($name);

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
     * @param $name
     * @param $type
     * @return string
     */
    protected function generateGetter($name, $type)
    {
        $name = $this->parseGetSetterName($name);

        $method = 'get' . ucfirst($name);

        $type = $this->parseType($type);

        return <<<GS
    /**
     * {$method}
     *
     * @return {$type}
     */
    public function {$method}()
    {
        return \$this->{$name};
    }

GS;
    }

    /**
     * Generate entity or repository getter and setter.
     *
     * @param        $name
     * @param string $type
     * @return string
     */
    protected function generateSetter($name, $type = '')
    {
        $name = $this->parseGetSetterName($name);

        $method = 'set' . ucfirst($name);

        $type = $this->parseType($type);

        return <<<GS
    /**
     * {$method}
     *
     * @param {$type} \${$name}
     * @return \$this
     */
    public function {$method}(\${$name})
    {
        \$this->{$name} = \${$name};

        return \$this;
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
     * @param     $name
     * @param     $dir
     * @param     $namespace
     * @param int $flag
     * @return mixed
     */
    abstract public function build($name, $dir, $namespace, $flag = BuilderAbstract::BUILD_PSR4);
}