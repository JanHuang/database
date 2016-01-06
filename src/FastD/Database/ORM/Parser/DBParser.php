<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/12/18
 * Time: 下午9:44
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Database\ORM\Parser;

use FastD\Database\Drivers\DriverInterface;

/**
 * The database parser.
 *
 * Class DBParser
 *
 * @package FastD\Database\ORM\Parser
 */
class DBParser
{
    use NameParseTrait;

    /**
     * @var DriverInterface
     */
    protected $driver;

    /**
     * @var TableParser[]
     */
    protected $tables = [];

    /**
     * DBParser constructor.
     *
     * @param DriverInterface $driverInterface
     */
    public function __construct(DriverInterface $driverInterface)
    {
        $this->driver = $driverInterface;

        $tables = $driverInterface
            ->createQuery('SHOW TABLES;')
            ->getQuery()
            ->getAll()
        ;

        foreach ($tables as $table) {
            $name = array_pop($table);
            $table = new TableParser($this->driver, $name, [], true);
            $this->tables[$table->getName()] = $table;
        }
    }

    /**
     * @param $name
     * @return bool
     */
    public function hasTable($name)
    {
        return array_key_exists($name, $this->tables);
    }

    /**
     * @return TableParser[]
     */
    public function getTables()
    {
        return $this->tables;
    }

    /**
     * @param $name
     * @return TableParser
     */
    public function getTable($name)
    {
        return $this->hasTable($name) ? $this->tables[$name] : null;
    }

    /**
     * @param TableParser $tableParser
     * @return $this
     */
    public function addTable(TableParser $tableParser)
    {
        $this->tables[$tableParser->getName()] = $tableParser;

        return $this;
    }

    /**
     * @return string
     */
    public function getCharset()
    {
        return $this->driver
            ->createQuery('SELECT @@character_set_database')
            ->getQuery()
            ->getOne()['@@character_set_database']
        ;
    }

    /**
     * @return string
     */
    public function getCurrentDBName()
    {
        $db = $this->driver
            ->createQuery('SELECT DATABASE() as name;')
            ->getQuery()
            ->getOne()
        ;

        return $db['name'];
    }
}