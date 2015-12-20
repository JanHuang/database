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

/**
 * Class Builder
 *
 * @package FastD\Database\ORM\Mapper
 */
class Builder
{
    /**
     * @var array
     */
    protected $structs = [];

    protected $driver;

    protected $parser;

    public function __construct(DriverInterface $driverInterface = null)
    {
        $this->driver = $driverInterface;

        $this->parser = new DBParser($driverInterface);
    }

    /**
     * @return StructBuilder[]
     */
    public function getSturct()
    {
        return $this->structs;
    }

    /**
     * @param array $structs
     * @return $this
     */
    public function addStruct(array $structs)
    {
        $this->structs[] = new StructBuilder($structs);

        return $this;
    }

    /**
     * @param array $strusts
     * @return $this
     */
    public function setStruct(array $strusts)
    {
        foreach ($strusts as $strust) {
            $this->addStruct($strust);
        }

        return $this;
    }

    public function getExistsTable()
    {
        $tables = $this->driver
            ->createQuery('SHOW TABLES;')
            ->getQuery()
            ->getAll()
        ;

        $list = [];
        foreach ($tables as $table) {
            $list[] = array_pop($table);
        }

        return $list;
    }

    public function createTableIfTableNotExists()
    {
        $tables = $this->getExistsTable();

        $sqls = [];
        foreach ($this->getSturct() as $struct) {
            $sqls[$struct->getTable()] = $struct->makeCreateTableSQL();
        }

        $result = [];
        foreach ($sqls as $name => $sql) {
            if (in_array($name, $tables)) {
                continue;
            }

            $result[] = $this->driver
                ->createQuery($sql)
                ->getQuery()
                ->getAll()
            ;
        }

        return $result;
    }

    public function updateTableIfTableExists()
    {
        $tables = $this->getExistsTable();

        $sqls = [];
        foreach ($this->getSturct() as $struct) {
            $sqls[$struct->getTable()] = $struct->makeUpdateTableSQL();
        }
        print_r($sqls);

        $result = [];
        foreach ($sqls as $name => $sql) {
            if (!in_array($name, $tables)) {
                continue;
            }

            $result[] = $this->driver
                ->createQuery($sql)
                ->getQuery()
                ->getOne()
            ;
        }

        return $result;
    }

    /**
     * @param        $dir
     * @param string $namespace
     */
    public function buildEntity($dir, $namespace = '')
    {
        foreach ($this->getSturct() as $struct) {
            $entity = new EntityBuilder($struct, $dir);
            $entity->buildEntity($namespace . $struct->getTable());
        }
    }
}