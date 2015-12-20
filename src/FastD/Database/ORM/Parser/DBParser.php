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
    /**
     * @var DriverInterface
     */
    protected $driver;

    /**
     * DBParser constructor.
     *
     * @param DriverInterface $driverInterface
     */
    public function __construct(DriverInterface $driverInterface)
    {
        $this->driver = $driverInterface;
    }

    /**
     * @return TableParser[]
     */
    public function getTables()
    {
        $tables = $this->driver
            ->createQuery('SHOW TABLES;')
            ->getQuery()
            ->getAll()
        ;

        $list = [];
        foreach ($tables as $table) {
            $name = array_pop($table);
            $list[] = new TableParser($this->driver, $name);
        }

        return $list;
    }

    /**
     * @param $name
     * @return TableParser
     */
    public function getTable($name)
    {
        return new TableParser($this->driver, $name);
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