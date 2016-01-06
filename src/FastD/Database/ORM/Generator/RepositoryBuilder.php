<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/12/30
 * Time: 下午10:36
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Database\ORM\Generator;

/**
 * Class RepositoryBuilder
 *
 * @package FastD\Database\ORM\Generator
 */
class RepositoryBuilder extends BuilderAbstract
{
    /**
     * @param     $name
     * @param     $dir
     * @param     $namespace
     * @param int $flag
     * @return mixed
     */
    public function build($name, $dir, $namespace, $flag = BuilderAbstract::BUILD_PSR4)
    {
        $name = $this->parseName(ucfirst($name));
        $table = $this->table->getName();
        $entity = ltrim($namespace . '\\Entity\\', '\\') . $name;
        $fields = $this->generateFields($name, $namespace, $dir);

        $namespace = ltrim($namespace . '\\Repository', '\\');
        $diff = $this->compare($namespace . '\\' . $name . 'Repository');

        $properties = [];

        $properties['table'] = <<<T
    /**
     * @var string
     */
    protected \$table = '{$table}';

T;
        $properties['entity'] = <<<R
    /**
     * @var string|null
     */
    protected \$entity = '{$entity}';

R;
        $properties = array_merge($diff['properties'], $properties);

        $properties = rtrim(implode(PHP_EOL, array_values($properties)));
        $methods = rtrim(implode(PHP_EOL, array_values($diff['methods'])));

        $repository = <<<R
<?php

namespace {$namespace};

use FastD\Database\ORM\Repository;

class {$name}Repository extends Repository
{
{$fields}

{$properties}
{$methods}
}
R;

        if (!is_dir($repositoryDir = $dir . '/Repository')) {
            mkdir($repositoryDir, 0755, true);
        }

        file_put_contents($dir . '/Repository/' . $name . 'Repository.php', $repository);

        return highlight_string($repository, true);
    }
}