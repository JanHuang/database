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
use FastD\Database\Schema\SchemaBuilder;
use FastD\Database\Schema\Structure\Table;

/**
 * Class FixtureLoader
 * @package Database\Fixtures
 */
class FixtureLoader
{
    /**
     * @var DriverInterface
     */
    protected $driver;

    /**
     * @var FixtureInterface[]
     */
    protected $fixtures = [];

    /**
     * Fixture constructor.
     * @param DriverInterface $driverInterface
     */
    public function __construct(DriverInterface $driverInterface)
    {
        $this->driver = $driverInterface;
    }

    /**
     * @param FixtureInterface $fixtureInterface
     */
    public function registerFixture(FixtureInterface $fixtureInterface)
    {
        $this->fixtures[] = $fixtureInterface;
    }

    /**
     * @return void
     */
    public function runSchema()
    {
        foreach ($this->fixtures as $fixture) {
            $fixture->loadSchema();
        }
    }

    /**
     * @return void
     */
    public function runDataSet()
    {
        foreach ($this->fixtures as $fixture) {
            $fixture->loadDataSet($this->driver);
        }
    }

    /**
     * Execute
     */
    public function run()
    {
        $this->runSchema();
        
        $this->runDataSet();
    }
}