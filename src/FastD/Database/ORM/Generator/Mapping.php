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

namespace FastD\Database\ORM\Generator;

use FastD\Database\Drivers\DriverInterface;
use FastD\Database\ORM\Parser\DBParser;
use FastD\Database\ORM\Parser\TableParser;

/**
 * Class Builder
 *
 * @package FastD\Database\ORM\Mapper
 */
class Mapping
{
    /**
     * @var DriverInterface
     */
    protected $driver;

    /**
     * @var DBParser
     */
    protected $parser;

    /**
     * Builder constructor.
     *
     * @param DriverInterface|null $driverInterface
     * @param bool $debug
     */
    public function __construct(DriverInterface $driverInterface = null, $debug = true)
    {
        $this->driver = $driverInterface;

        $this->parser = new DBParser($driverInterface, $debug);
    }

    /**
     * @return DBParser
     */
    public function getParser()
    {
        return $this->parser;
    }

    /**
     * @return TableParser[]
     */
    public function getTables()
    {
        return $this->parser->getTables();
    }

    /**
     * @param array $table
     * @return $this
     */
    public function addTable(array $table)
    {
        if (!isset($table['table'])) {
            throw new \RuntimeException('Table name is undefined.');
        }

        if ($this->parser->hasTable($table['table'])) {
            $this->parser->getTable($table['table'])->setNewFields($table);
        } else {
            $table = new TableParser(
                $this->driver,
                $table['table'],
                $table,
                $this->parser->hasTable($table['table'])
            );
            $this->parser->addTable($table);
        }
        return $this;
    }

    /**
     * @param array $tables
     * @return $this
     */
    public function setTables(array $tables)
    {
        foreach ($tables as $table) {
            $this->addTable($table);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function makeAllSql()
    {
        $query = [];
        foreach ($this->getTables() as $table) {
            $sql = $table->makeSQL();
            if (!empty($sql)) {
                $query[] = $sql;
            }
        }
        return $query;
    }

    /**
     * Update table if table is exists.
     * Create table if table is not exists.
     *
     * @return bool
     */
    public function updateTables()
    {
        foreach ($this->makeAllSql() as $sql) {
            $this->driver->createQuery($sql)->getQuery()->getAll();
        }
        return true;
    }

    /**
     * Build entity and repository.
     *
     * @param $namespace
     * @param $dir
     * @return array
     */
    public function buildEntity($namespace, $dir)
    {
        $result = [];

        $namespace = empty($namespace) ? '' : $namespace;

        foreach ($this->getTables() as $table) {
            if (empty($table->getNewFields())) {
                continue;
            }
            $name = $table->getName();
            $entity = new EntityBuilder($table);
            $result['entity'][$name] = $entity->build($name, $dir, $namespace);

            $entity = new RepositoryBuilder($table, $dir);
            $result['repository'][$name] = $entity->build($name, $dir, $namespace);
        }

        return $result;
    }

    /**
     * @param $dir
     * @return bool
     */
    public function buildYml($dir)
    {
        foreach ($this->getTables() as $table) {
            if (empty($table->getNewFields())) {
                continue;
            }
            $yml = new YmlBuilder($table);
            $yml->build($table->getName(), $dir, null);
        }

        return true;
    }
}