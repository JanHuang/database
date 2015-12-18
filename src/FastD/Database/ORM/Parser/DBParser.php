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
    protected $driver;

    public function __construct(DriverInterface $driverInterface)
    {
        $this->driver = $driverInterface;
    }

    public function getTables()
    {}

    public function getTableStructure($name)
    {

    }

    public function compareTableStructure($name, array $fields)
    {

    }

    public function getCurrentDB()
    {

    }
}