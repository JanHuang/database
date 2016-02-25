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

/**
 * Class EntityBuilder
 *
 * @package FastD\Database\ORM\Generator
 */
class EntityBuilder extends BuilderAbstract
{
    public function build($name, $dir, $namespace, $flag = BuilderAbstract::BUILD_PSR4)
    {
        $name = $this->parseName(ucfirst($name));
        $properties = [];
        $methods = [];

        $repository = ltrim("{$namespace}\\Repository\\{$name}Repository", '\\');
        $table = $this->table->getName();

        $properties['table'] = <<<T
    /**
     * @var string
     */
    protected \$table = '{$table}';

T;
        $properties['repository'] = <<<R
    /**
     * @var string|null
     */
    protected \$repository = '{$repository}';

R;

        foreach ($this->table->getNewFields() as $alias => $field) {
            $properties[$alias] = $this->generateProperty($alias, $field->getType());
            $methods[$this->parseGetSetterMethod($alias, 'get')] = $this->generateGetter($alias, $field->getType());
            $methods[$this->parseGetSetterMethod($alias, 'set')] = $this->generateSetter($alias, $field->getType());
        }

        $fields = $this->generateFields($name, $namespace, $dir);

        $namespace = ltrim($namespace . '\\Entity', '\\');

        $diff = $this->compare($namespace . '\\' . $name);

        $properties = array_merge($diff['properties'], $properties);

        $methods = array_merge($methods, $diff['methods']);

        $properties = rtrim(implode(PHP_EOL, array_values($properties)));
        $methods = rtrim(implode(PHP_EOL, array_values($methods)));

        $entity = <<<E
<?php

namespace {$namespace};

use FastD\Database\ORM\Entity;

class {$name} extends Entity
{
{$fields}

{$properties}
{$methods}
}
E;

        if (!is_dir($entityDir = $dir . '/Entity')) {
            mkdir($entityDir, 0755, true);
        }

        file_put_contents($dir . '/Entity/' . $name . '.php', $entity);

        return highlight_string($entity, true);
    }
}