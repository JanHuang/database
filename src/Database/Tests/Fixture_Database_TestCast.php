<?php
/**
 *
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2016
 *
 * @link      https://www.github.com/janhuang
 * @link      http://www.fast-d.cn/
 */

namespace FastD\Database\Tests;

use FastD\Database\Drivers\MySQLDriver;
use PHPUnit_Extensions_Database_DB_IDatabaseConnection;

/**
 * Class Fixture_Database_TestCast
 *
 * @package FastD\Database\Tests
 */
abstract class Fixture_Database_TestCast extends \PHPUnit_Extensions_Database_TestCase
{
    /**
     * Custom connection information.
     *
     * @const array
     */
    const CONNECTION = [
        'database_host'      => '127.0.0.1',
        'database_port'      => '3306',
        'database_name'      => 'dbunit',
        'database_user'      => 'root',
        'database_pwd'       => '123456'
    ];

    /**
     * @const name.
     */
    const NAME = null;

    /**
     * @return \PDO
     */
    protected function createPdo(array $config = null)
    {
        if (null === $config) {
            $config = static::CONNECTION;
        }

        $dsn = new class($config)
        {
            private $user;
            private $pwd;
            private $charset;
            private $dsn;
            private $name;

            public function __construct($connection)
            {
                $this->dsn = sprintf('mysql:host=%s;dbname=%s', $connection['database_host'], $connection['database_name']);
                $this->user = $connection['database_user'];
                $this->pwd = $connection['database_pwd'];
                $this->charset = isset($connection['database_charset']) ? $connection['database_charset'] : 'utf8';
                $this->name = $connection['database_name'];
            }

            public function getDSN()
            {
                return $this->dsn;
            }

            public function getUser()
            {
                return $this->user;
            }

            public function getPwd()
            {
                return $this->pwd;
            }

            public function getCharset()
            {
                return $this->charset;
            }

            public function getName()
            {
                return $this->name;
            }
        };

        return new \PDO($dsn->getDSN(), $dsn->getUser(), $dsn->getPwd());
    }

    /**
     * Returns the test database connection.
     *
     * @return PHPUnit_Extensions_Database_DB_IDatabaseConnection
     */
    protected function getConnection()
    {
        return $this->createDefaultDBConnection($this->createPdo(), static::NAME);
    }

    /**
     * Returns the test dataset.
     *
     * @return \PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    protected function getDataSet()
    {
        return new \PHPUnit_Extensions_Database_DataSet_YamlDataSet(__DIR__ . '/DataSet/base.yml');
    }

    /**
     * @param $config
     * @return MySQLDriver
     */
    public function getLocalDriver(array $config = null)
    {
        return new MySQLDriver($config ?? static::CONNECTION);
    }
}