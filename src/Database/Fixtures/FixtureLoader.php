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

/**
 * Class Fixture
 * @package Database\Fixtures
 */
class Fixture
{
    /**
     * @var SchemaSet[]
     */
    protected $schemaSets = [];

    /**
     * @var DataSet[]
     */
    protected $dataSets = [];

    /**
     * @var DriverInterface
     */
    protected $driver;

    /**
     * Fixture constructor.
     * @param DriverInterface $driverInterface
     */
    public function __construct(DriverInterface $driverInterface)
    {
        $this->driver = $driverInterface;
    }

    /**
     * @param SchemaSet $schemaSet
     * @return $this
     */
    public function registerSchemaSet(SchemaSet $schemaSet)
    {
        $this->schemaSets[] = $schemaSet;

        return $this;
    }

    /**
     * @return DataSet[]
     */
    public function getSchemaSets()
    {
        return $this->dataSets;
    }

    /**
     * @param DataSet $dataSet
     * @return $this
     */
    public function registerDataSet(DataSet $dataSet)
    {
        $this->dataSets[] = $dataSet;

        return $this;
    }

    /**
     * @return DataSet[]
     */
    public function getDataSets()
    {
        return $this->dataSets;
    }

    /**
     * Execute
     */
    public function run()
    {
        foreach ($this->getSchemaSets() as $schemaSet) {
            $schemaSet->run($this->driver);
        }

        foreach ($this->getDataSets() as $dataSet) {
            $dataSet->run($this->driver);
        }
    }
}