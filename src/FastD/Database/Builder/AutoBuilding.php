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

    protected function getConstants($value)
    {
        $fields = new Property('FIELDS', Property::PROPERTY_CONST);
        $fields->setValue('\\' . $value . '::FIELDS');

        $alias = new Property('ALIAS', Property::PROPERTY_CONST);
        $alias->setValue('\\' . $value . '::ALIAS');

        $primary = new Property('PRIMARY', Property::PROPERTY_CONST);
        $primary->setValue('\\' . $value . '::PRIMARY');

        return [$fields, $alias, $primary];
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
            $file = $dir . '/' . strtolower($table->getTable()) . '.yml';
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

    /**
     * @param $dir
     * @param string $namespace
     * @param bool $force
     * @return int
     */
    public function saveEntityTo($dir, $namespace = '', $force = false)
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

            $entity = new Generator($name, $namespace . '\\Entity', Object::OBJECT_CLASS);

            $entity->setExtends($object);

            $properties = [];
            $methods = [];

            foreach ($table->getFields() as $field) {
                $properties[] = new Property($field->getAlias());
                $methods[] = new GetSetter($field->getAlias());
            }

            $entity->setProperties(array_merge($this->getConstants($namespace . '\\Field\\' . $name), $properties));
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

    /**
     * @param $dir
     * @param string $namespace
     * @param bool $force
     * @return int
     */
    public function saveRepositoryTo($dir, $namespace = '', $force = false)
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

            $repository = new Generator($name, $namespace . '\\Repository', Object::OBJECT_CLASS);

            $repository->setExtends($object);

            $repository->setProperties($this->getConstants($namespace . '\\Field\\' . $name));

            $content = '<?php' . PHP_EOL . $repository->generate();

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

    /**
     * @param $dir
     * @param null $namespace
     * @param bool $force
     * @return int
     */
    public function saveFieldTo($dir, $namespace = null, $force = false)
    {
        $dir = str_replace('//', '/', $dir . '/Field');

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

            $fields = [];
            $alias = [];

            $primaryConst = new Property('PRIMARY', Property::PROPERTY_CONST);

            foreach ($table->getFields() as $value) {
                $fields[$value->getAlias()] = [
                    'alias' => $value->getAlias(),
                    'name' => $value->getName(),
                    'length' => $value->getLength(),
                    'type' => $value->getType(),
                    'notnull' => $value->isNullable(),
                    'unsigned' => $value->isUnsigned(),
                    'default' => $value->getDefault(),
                ];

                $alias[$value->getName()] = $value->getAlias();

                if ($value->isPrimary()) {
                    $primaryConst->setValue($value->getName());
                }
            }

            $field = new Generator($name, $namespace . '\\Field', Object::OBJECT_CLASS);

            $fieldsConst = new Property('FIELDS', Property::PROPERTY_CONST);
            $fieldsConst->setValue($fields);

            $aliasConst = new Property('ALIAS', Property::PROPERTY_CONST);
            $aliasConst->setValue($alias);

            $constants = [
                $fieldsConst,
                $aliasConst,
                $primaryConst
            ];

            $field->setProperties($constants);

            $content = '<?php' . PHP_EOL . $field->generate();;

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

    /**
     * @param $dir
     * @param null $namespace
     * @param bool $force
     * @return array
     */
    public function saveTo($dir, $namespace = null, $force = false)
    {
        $result = [];

        $result['yml_to'] = $this->saveYmlTo($dir, $force);
        $result['entity_to'] = $this->saveEntityTo($dir, $namespace, $force);
        $result['repository_to'] = $this->saveRepositoryTo($dir, $namespace, $force);
        $result['field_to'] = $this->saveFieldTo($dir, $namespace, $force);

        return $result;
    }
}