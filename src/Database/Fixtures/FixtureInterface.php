<?php
/**
 *
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2016
 *
 * @link      https://www.github.com/janhuang
 * @link      http://www.fast-d.cn/
 */

namespace FastD\Database\Fixtures;

use FastD\Database\Drivers\DriverInterface;
use FastD\Database\Schema\Structure\Table;

/**
 * Interface FixtureInterface
 * @package Database\Fixtures
 */
interface FixtureInterface
{
    /**
     * Create schema
     *
     * @return Table
     */
    public function loadSchema();

    /**
     * Fill DB data.
     *
     * @param DriverInterface $driverInterface
     * @return mixed
     */
    public function loadDataSet(DriverInterface $driverInterface);
}