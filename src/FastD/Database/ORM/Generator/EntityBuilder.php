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

    public function fetchContent($name)
    {
        if (!class_exists($name)) {
            return '';
        }

        $name = new \ReflectionClass($name);

        return '';
    }

    public function build()
    {
        // TODO: Implement build() method.
    }
}