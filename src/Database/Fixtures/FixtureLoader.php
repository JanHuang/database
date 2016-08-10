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
     * @var SchemaBuilder
     */
    protected $schemaBuilder;

    /**
     * Fixture constructor.
     * @param DriverInterface $driverInterface
     */
    public function __construct(DriverInterface $driverInterface)
    {
        $this->driver = $driverInterface;

        $this->schemaBuilder = new SchemaBuilder();
    }

    /**
     * @param FixtureInterface $fixtureInterface
     */
    public function registerFixture(FixtureInterface $fixtureInterface)
    {
        $this->fixtures[] = $fixtureInterface;

        if ($fixtureInterface->loadSchema() instanceof Table) {
            $this->schemaBuilder->addTable($fixtureInterface->loadSchema());
        }
    }

    /**
     * @return void
     */
    public function runSchema()
    {
        foreach ($this->schemaBuilder as $table) {
            $sql = $this->schemaBuilder->update();
            $this->driver->query($sql)->execute();
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