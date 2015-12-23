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
class Builder
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
     */
    public function __construct(DriverInterface $driverInterface = null)
    {
        $this->driver = $driverInterface;

        $this->parser = new DBParser($driverInterface);
    }

    /**
     * @return StructBuilder[]
     */
    public function getStructure()
    {
        return $this->parser->getTables();
    }

    /**
     * @param array $structs
     * @return $this
     */
    public function addStructure(array $structs)
    {
        if (!isset($structs['table'])) {
            throw new \RuntimeException('Table name is undefined.');
        }

        if ($this->parser->hasTable($structs['table'])) {
            $this->parser->getTable($structs['table'])->setNewFields($structs);
        } else {
            $table = new TableParser(
                $this->driver,
                $structs['table'],
                $structs,
                $this->parser->hasTable($structs['table'])
            );
            $this->parser->addTable($table);
        }

        return $this;
    }

    /**
     * @param array $strusts
     * @return $this
     */
    public function setStructure(array $strusts)
    {
        foreach ($strusts as $strust) {
            $this->addStructure($strust);
        }

        return $this;
    }

    /**
     * @return \FastD\Database\ORM\Parser\TableParser[]
     */
    public function getTables()
    {
        return $this->parser->getTables();
    }

    public function updateTables()
    {
        foreach ($this->structs as $struct) {
            $struct->makeSQL();
        }
    }

    /**
     * @param        $dir
     * @param string $namespace
     */
    public function buildEntity($dir, $namespace = '')
    {
        foreach ($this->getSturct() as $struct) {
            $entity = new EntityBuilder($struct, $dir);
            $entity->buildEntity($namespace.$struct->getTable());
        }
    }
}