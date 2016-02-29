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
     * @var bool
     */
    protected $debug;

    /**
     * Builder constructor.
     *
     * @param DriverInterface|null $driverInterface
     * @param $originDir
     * @param bool $debug
     */
    public function __construct(DriverInterface $driverInterface = null, $originDir = null, $debug = true)
    {
        $this->driver = $driverInterface;

        $this->debug = $debug;

        $this->parser = new Parser($driverInterface, $originDir);

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
        return $this->parser->getTables();
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
     * @param $value
     * @return array
     */
    protected function getConstants($value)
    {
        $fields = new Property('FIELDS', Property::PROPERTY_CONST);
        $fields->setValue('\\' . $value . '::FIELDS');

        $alias = new Property('ALIAS', Property::PROPERTY_CONST);
        $alias->setValue('\\' . $value . '::ALIAS');

        $primary = new Property('PRIMARY', Property::PROPERTY_CONST);
        $primary->setValue('\\' . $value . '::PRIMARY');

        $table = new Property('TABLE', Property::PROPERTY_CONST);
        $table->setValue('\\' . $value . '::TABLE');

        return [
            'FIELDS' => $fields,
            'ALIAS' => $alias,
            'PRIMARY' => $primary,
            'TABLE' => $table
        ];
    }

    /**
     * @param $dir
     * @param bool $force
     * @return int
     */
    public function saveYmlTo($dir, $force = false)
    {
        $dir = str_replace('//', '/', $dir);

        foreach ($this->getParser()->getTablesByDb() as $table) {
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
            $name = ucfirst($table->rename($table->getTable()));
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
                $properties[$field->getAlias()] = new Property($field->getAlias());
                $methods[] = new GetSetter($field->getAlias());
            }

            $entity->setProperties(array_merge($properties, $this->getConstants($namespace . '\\Field\\' . $name)));
            $entity->setMethods($methods, true);

            if (file_exists($file)) {
                if (true === $force) {
                    $entity->save($file);
                }
            } else {
                $entity->save($file);
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
            $name = ucfirst($table->rename($table->getTable()));
            $file = $dir . '/' . $name . 'Repository.php';
            if (!is_dir($dir)) {
                if (true === $force) {
                    mkdir($dir, 0755, true);
                } else {
                    throw new \RuntimeException(sprintf('Directory ["%s"] is not such. Please execute force or create it.', $dir));
                }
            }

            $object = new Object('Repository', 'FastD\Database\Orm');

            $repository = new Generator($name . 'Repository', $namespace . '\\Repository', Object::OBJECT_CLASS);

            $repository->setExtends($object);
            $repository->setProperties($this->getConstants($namespace . '\\Field\\' . $name), true);
            if (file_exists($file)) {
                if (true === $force) {
                    $repository->save($file);
                }
            } else {
                $repository->save($file);
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
            $name = ucfirst($table->rename($table->getTable()));
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

            $tableConst = new Property('TABLE', Property::PROPERTY_CONST);
            $tableConst->setValue($table->getFullTable());

            $constants = [
                $fieldsConst,
                $aliasConst,
                $primaryConst,
                $tableConst
            ];

            $field->setProperties($constants, true);

            if (file_exists($file)) {
                if (true === $force) {
                    $field->save($file);
                }
            } else {
                $field->save($file);
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

        $result['entity_to'] = $this->saveEntityTo($dir, $namespace, $force);
        $result['repository_to'] = $this->saveRepositoryTo($dir, $namespace, $force);
        $result['field_to'] = $this->saveFieldTo($dir, $namespace, $force);

        return $result;
    }

    /**
     * 通过 Yml 配置文件建立数据库
     *
     * @param $dir
     * @param null $namespace
     * @param bool $force
     * @param int  $flag
     * @return array
     */
    public function ymlToTable($dir, $namespace = null, $force = false, $flag = Table::TABLE_CHANGE)
    {
        $this->tables = $this->parser->getTablesByYml();

        foreach ($this->getParser()->getTablesByYml() as $table) {
            $sql = $table->toSql($flag);
            $this->driver->query($sql)->execute()->getAll();
            if ($this->debug) {
                echo PHP_EOL;
                echo $sql;
                echo PHP_EOL;
            }
        }

        return $this->saveTo($dir, $namespace, $force);
    }

    /**
     * 通过已有数据表建立 Yml 配置文件
     *
     * @param $dir
     * @param null $namespace
     * @param bool $force
     * @return array
     */
    public function tableToYml($dir, $namespace = null, $force = false)
    {
        $this->tables = $this->parser->getTablesByDb();

        $this->saveYmlTo($dir, $force);

        return $this->saveTo($dir, $namespace, $force);
    }
}