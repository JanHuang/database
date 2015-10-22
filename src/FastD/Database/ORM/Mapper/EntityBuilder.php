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

namespace FastD\Database\ORM\Mapper;

class EntityBuilder
{
    protected $dir;

    protected $struct;

    public function __construct(StructBuilder $struct, $dir = '')
    {
        $this->struct = $struct;

        $this->dir = $dir;
    }

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

    public function buildEntity($name)
    {
        $namespace = '';
        if (false !== ($index = strrpos($name, '\\'))) {
            $namespace = ucfirst(substr($name, 0, $index));
            $name = substr($name, $index + 1);
        }

        $property = '';
        $methods = '';

        foreach ($this->struct->getFields() as $field) {
            $property .= PHP_EOL . $this->buildProperty($field->getMapName(), $field->getType()) . PHP_EOL;
            $methods .= PHP_EOL . $this->buildGetSetter($field->getMapName(), $field->getType()) . PHP_EOL;
        }

        $construct = $this->buildConstruct();

        $name = ucfirst($name);

        $repository = " = '{$name}Repository'";
        if (!empty($namespace)) {
            $repository = " = '{$namespace}\\Repository\\{$name}Repository'";
        }

        $this->buildRepository($name, $namespace);

        if (!empty($namespace)) {
            $namespace = PHP_EOL . 'namespace ' . $namespace . '\\Entity;' . PHP_EOL;
        }

        $entity = <<<E
<?php
{$namespace}
class {$name}
{
    /**
     * @var string|null
     */
    protected \$repository{$repository};
    {$property}
    {$construct}
    {$methods}
}
E;

        if (!is_dir($entityDir = $this->dir . '/Entity')) {
            mkdir($entityDir, 0755, true);
        }

        file_put_contents($this->dir . '/Entity/' . $name . '.php', $entity);
    }

    protected function buildConstruct()
    {
        if (null === $this->struct->getPrimary()) {
            return '';
        }

        return <<<C

    /**
     * @param int \$id
     */
    public function __construct(\$id = null)
    {
        \$this->{$this->struct->getPrimary()->getName()} = \$id;
    }
C;
    }

    protected function buildProperty($name, $type = '')
    {
        if (strpos($name, '_')) {
            $arr = explode('_', $name);
            $name = array_shift($arr);
            foreach ($arr as $value) {
                $name .= ucfirst($value);
            }
        }

        $type = $this->parseType($type);

        return  <<<P
    /**
     * @var {$type}
     */
    protected \${$name};
P;

    }

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

    protected function buildRepository($name, $namespace = '')
    {
        $entity = $name;
        if (!empty($namespace)) {
            $entity = "{$namespace}\\Entity\\{$name}";
            $namespace = PHP_EOL . 'namespace ' . $namespace . '\\Repository;' . PHP_EOL;
        }

        $maps = [];
        $mapKeys = [];
        foreach ($this->struct->getFields() as $field) {
            $mapName = $field->getMapName();
            if (empty($mapName)) {
                $mapName = $field->getName();
            }
            $mapKeys[] = $mapName;
            $maps[] = <<<M
        '{$mapName}' => [
            'type' => '{$field->getType()}',
            'name' => '{$field->getName()}',
        ],
M;
        }

        $mapKeys = '\''. implode("', '", $mapKeys) . '\'';

        $maps = implode(PHP_EOL, $maps);

        $table = $this->struct->getPrefix() . $this->struct->getTable() . $this->struct->getSuffix();

        $repository = <<<R
<?php
{$namespace}
use FastD\Database\ORM\Repository;

class {$name}Repository extends Repository
{
    protected \$table = '{$table}';

    protected \$fields = [
{$maps}
    ];

    protected \$keys = [{$mapKeys}];

    protected \$entity = '{$entity}';
}
R;

        if (!is_dir($repositoryDir = $this->dir . '/Repository')) {
            mkdir($repositoryDir, 0755, true);
        }

        file_put_contents($this->dir . '/Repository/' . $name . 'Repository.php', $repository);
    }
}