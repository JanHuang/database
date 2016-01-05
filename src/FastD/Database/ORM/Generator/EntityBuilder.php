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
        $name = ucfirst($name);
        $properties= [];
        $methods = [];

        foreach ($this->table->getFields() as $alias => $field) {
            $properties[] = $this->generateProperty($alias, $field->getType());
            $methods[] = $this->generateGetSetter($alias, $field->getType());
        }

        $repository = ltrim("{$namespace}\\Repository\\{$name}Repository", '\\');

        $table = $this->table->getName();
        $fields = $this->generateFields($name, $namespace, $dir);

        $namespace = ltrim($namespace . '\\Entity', '\\');

        $this->reflectionFile($namespace . '\\' . $name);

        $properties = implode(PHP_EOL, $properties);
        $methods = implode(PHP_EOL, $methods);

        $entity = <<<E
<?php

namespace {$namespace};

use FastD\Database\ORM\Entity;

class {$name} extends Entity
{
    {$fields}

    /**
     * @var string
     */
    protected \$table = '{$table}';

    /**
     * @var string|null
     */
    protected \$repository = '{$repository}';
    {$properties}
    {$methods}
}
E;

        if (!is_dir($entityDir = $dir . '/Entity')) {
            mkdir($entityDir, 0755, true);
        }

        file_put_contents($dir . '/Entity/' . $name . '.php', $entity);
    }
}