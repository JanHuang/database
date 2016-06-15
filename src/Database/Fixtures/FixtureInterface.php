<?php
/**
 *
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2016
 *
 * @link      https://www.github.com/janhuang
 * @link      http://www.fast-d.cn/
 */

namespace Database\Fixtures;

use FastD\Database\DriverInterface;
use FastD\Database\Schema\Schema;

/**
 * Interface FixtureInterface
 * @package Database\Fixtures
 */
interface FixtureInterface
{
    /**
     * Create schema
     *
     * @return Schema
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