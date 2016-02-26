<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/10/11
 * Time: 上午1:13
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Database\Builder;

use FastD\Database\DriverInterface;
use FastD\Generator\Factory\GetSetter;
use FastD\Generator\Factory\Property;
use FastD\Generator\Generator;
use FastD\Generator\Factory\Object;

/**
 * 自动生成器
 *
 * Class AutoBuilding
 *
 * @package FastD\Database\ORM\AutoBuilding
 */
class AutoBuilding
{
    /**
     * @var DriverInterface
     */
    protected $driver;

    /**
     * @var Parser
     */
    protected $parser;

    /**
     * @var Table[]
     */
    protected $tables;

    /**
     * @var string
     */
    protected $namespace;

    /**
     * Builder constructor.
     *
     * @param DriverInterface|null $driverInterface
     * @param bool $debug
     */
    public function __construct(DriverInterface $driverInterface = null, $debug = true)
    {
        $this->driver = $driverInterface;

        $this->parser = new Parser($driverInterface);

        $this->tables = $this->parser->getTables();
    }

    /**
     * @return Parser
     */
    public function getParser()
    {
        return $this->parser;
    }

    /**
     * @return Table[]
     */
    public function getTables()
    {
        return $this->parser->getTablesByDb();
    }

    /**
     * @param Table $table
     * @return $this
     */
    public function addTable(Table $table)
    {
        $this->tables[$table->getTable()] = $table;

        return $this;
    }

    /**
     * @param Table[] $tables
     * @return $this
     */
    public function setTables(array $tables)
    {
        $this->tables = $tables;

        return $this;
    }

    /**
     * @param $dir
     * @param bool $force
     * @return int
     */
    public function saveYmlTo($dir, $force = false)
    {
        $dir = str_replace('//', '/', $dir . '/yml');

        foreach ($this->tables as $table) {
            $file = $dir . '/' . ucfirst($table->getTable()) . '.yml';
            if (!is_dir($dir)) {
                if (true === $force) {
                    mkdir($dir, 0755, true);
                } else {
                    throw new \RuntimeException(sprintf('Directory ["%s"] is not such. Please execute force or create it.', $dir));
                }
            }

            if (file_exists($file)) {
                if (true === $force) {
                    file_put_contents($file, $table->toYml());
                }
            } else {
                file_put_contents($file, $table->toYml());
            }
        }

        return 0;
    }

    public function saveEntityTo($dir, $force = false)
    {
        $dir = str_replace('//', '/', $dir . '/Entity');

        foreach ($this->tables as $table) {
            $name = ucfirst($table->getTable());
            $file = $dir . '/' . $name . '.php';
            if (!is_dir($dir)) {
                if (true === $force) {
                    mkdir($dir, 0755, true);
                } else {
                    throw new \RuntimeException(sprintf('Directory ["%s"] is not such. Please execute force or create it.', $dir));
                }
            }

            $object = new Object('Entity', 'FastD\Database\Orm');

            $entity = new Generator($name, $this->namespace . '\\Entity', Object::OBJECT_CLASS);

            $entity->setExtends($object);

            $properties = [];
            $methods = [];

            foreach ($table->getFields() as $field) {
                $properties[] = new Property($field->getName());
                $methods[] = new GetSetter($field->getName());
            }

            $entity->setProperties($properties);
            $entity->setMethods($methods);

            $content = '<?php' . PHP_EOL . $entity->generate();

            if (file_exists($file)) {
                if (true === $force) {
                    file_put_contents($file, $content);
                }
            } else {
                file_put_contents($file, $content);
            }
        }

        return 0;
    }

    public function saveRepositoryTo($dir, $force = false)
    {
        $dir = str_replace('//', '/', $dir . '/Repository');

        foreach ($this->tables as $table) {
            $name = ucfirst($table->getTable());
            $file = $dir . '/' . $name . 'Repository.php';
            if (!is_dir($dir)) {
                if (true === $force) {
                    mkdir($dir, 0755, true);
                } else {
                    throw new \RuntimeException(sprintf('Directory ["%s"] is not such. Please execute force or create it.', $dir));
                }
            }

            $object = new Object('Repository', 'FastD\Database\Orm');

            $entity = new Generator($name, $this->namespace . '\\Repository', Object::OBJECT_CLASS);

            $entity->setExtends($object);

            $content = '<?php' . PHP_EOL . $entity->generate();

            if (file_exists($file)) {
                if (true === $force) {
                    file_put_contents($file, $content);
                }
            } else {
                file_put_contents($file, $content);
            }
        }

        return 0;
    }

    public function saveTo($dir, $namespace = null, $force = false)
    {
        $result = [];

        $this->namespace = $namespace;

        $result['yml_to'] = $this->saveYmlTo($dir, $force);
        $result['entity_to'] = $this->saveEntityTo($dir, $force);
        $result['repository_to'] = $this->saveRepositoryTo($dir, $force);

        return $result;
    }
}