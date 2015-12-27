<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/10/11
 * Time: 下午10:00
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
 * Class EntityBuilder
 *
 * @package FastD\Database\ORM\Generator
 */
class EntityBuilder
{
    /**
     * @var string
     */
    protected $dir;

    /**
     * @var TableParser
     */
    protected $table;

    /**
     * EntityBuilder constructor.
     *
     * @param TableParser $tableParser
     * @param string      $dir
     */
    public function __construct(TableParser $tableParser, $dir = '')
    {
        $this->table = $tableParser;

        $this->dir = $dir;
    }

    /**
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
     */
    public function buildEntity($name)
    {
        $namespace = '';
        if (false !== ($index = strrpos($name, '\\'))) {
            $namespace = ucfirst(substr($name, 0, $index));
            $name = substr($name, $index + 1);
        }

        $property = '';
        $methods = '';
        $primary = '';

        foreach ($this->table->getFields() as $alias => $field) {
            if ($field->isPrimary()) {
                $primary = $this->buildProperty('primary', $field->getType(), $name);
            }
            $property .= PHP_EOL . $this->buildProperty($alias, $field->getType()) . PHP_EOL;
            $methods .= PHP_EOL . $this->buildGetSetter($alias, $field->getType()) . PHP_EOL;
        }

        $name = ucfirst($name);

        $repository = " = '{$name}Repository'";
        if (!empty($namespace)) {
            $repository = " = '{$namespace}\\Repository\\{$name}Repository'";
        }

        $map = $this->buildRepository($name, $namespace);

        $table = $this->table->getName();

        if (!empty($namespace)) {
            $namespace = PHP_EOL . 'namespace ' . $namespace . '\\Entity;' . PHP_EOL;
        }

        $property = ltrim($property, PHP_EOL);
        $methods = rtrim($methods, PHP_EOL);

        $entity = <<<E
<?php
{$namespace}
use FastD\Database\ORM\Entity;

class {$name} extends Entity
{
    /**
     * @var string
     */
    protected \$table = '{$table}';

    /**
     * @var array
     */
    protected \$structure = [
{$map['maps']}
    ];

    /**
     * @var array
     */
    protected \$fields = [
        {$map['keys']}
    ];

    /**
     * @var string|null
     */
    protected \$repository{$repository};
    {$primary}
{$property}
    {$methods}
}
E;

        if (!is_dir($entityDir = $this->dir . '/Entity')) {
            mkdir($entityDir, 0755, true);
        }

        file_put_contents($this->dir . '/Entity/' . $name . '.php', $entity);
    }

    /**
     * @param        $name
     * @param string $type
     * @param null   $defaultValue
     * @return string
     */
    protected function buildProperty($name, $type = '', $defaultValue = null)
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
     * @param        $name
     * @param string $type
     * @return string
     */
    protected function buildGetSetter($name, $type = '')
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

        $getSetter = <<<GS
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

        return $getSetter;
    }

    /**
     * @param        $name
     * @param string $namespace
     * @return array
     */
    protected function buildRepository($name, $namespace = '')
    {
        $entity = $name;
        if (!empty($namespace)) {
            $entity = "{$namespace}\\Entity\\{$name}";
            $namespace = PHP_EOL . 'namespace ' . $namespace . '\\Repository;' . PHP_EOL;
        }

        $maps = [];
        $mapKeys = [];
        foreach ($this->table->getNewFields() as $alias => $field) {
            $mapName = $alias;
            if (empty($mapName)) {
                $mapName = $field->getName();
            }
            $mapKeys[] = "'" . $field->getName() . '\' => ' . "'" . $mapName . "'";
            $maps[] = <<<M
        '{$mapName}' => [
            'type' => '{$field->getType()}',
            'name' => '{$field->getName()}',
            'length'=> {$field->getLength()},
        ],
M;
        }

        $mapKeys = implode(',', $mapKeys);

        $maps = implode(PHP_EOL, $maps);

        $table = $this->table->getName();

        $repository = <<<R
<?php
{$namespace}
use FastD\Database\ORM\Repository;

class {$name}Repository extends Repository
{
    /**
     * @var string
     */
    protected \$table = '{$table}';

    /**
     * @var array
     */
    protected \$structure = [
{$maps}
    ];

    /**
     * @var array
     */
    protected \$fields = [{$mapKeys}];

    /**
     * @var string
     */
    protected \$entity = '{$entity}';
}
R;

        if (!is_dir($repositoryDir = $this->dir . '/Repository')) {
            mkdir($repositoryDir, 0755, true);
        }

        file_put_contents($this->dir . '/Repository/' . $name . 'Repository.php', $repository);

        return [
            'maps' => $maps,
            'keys' => $mapKeys
        ];
    }

    public function fetchContent($name)
    {
        if (!class_exists($name)) {
            return '';
        }

        $name = new \ReflectionClass($name);

        return '';
    }
}