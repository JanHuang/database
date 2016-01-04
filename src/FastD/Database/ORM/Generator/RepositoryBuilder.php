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
        $name = ucfirst($name);
        $fields = $this->generateFields($name, $namespace, $dir);
        $table = $this->table->getName();

        $entity = ltrim($namespace . '\\Entity\\', '\\') . $name;
        $namespace = ltrim($namespace . '\\Repository', '\\');

        $repository = <<<R
<?php

namespace {$namespace};

use FastD\Database\ORM\Repository;

class {$name}Repository extends Repository
{
    /**
     * @var string
     */
    protected \$table = '{$table}';

    {$fields}

    /**
     * @var string
     */
    protected \$entity = '{$entity}';
}
R;

        if (!is_dir($repositoryDir = $dir . '/Repository')) {
            mkdir($repositoryDir, 0755, true);
        }

        file_put_contents($dir . '/Repository/' . $name . 'Repository.php', $repository);
    }
}