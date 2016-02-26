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
     * Builder constructor.
     *
     * @param DriverInterface|null $driverInterface
     * @param bool $debug
     */
    public function __construct(DriverInterface $driverInterface = null, $debug = true)
    {
        $this->driver = $driverInterface;

        $this->parser = new Parser($driverInterface);
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

    }

    /**
     * @param array $tables
     * @return $this
     */
    public function setTables(array $tables)
    {

    }
}