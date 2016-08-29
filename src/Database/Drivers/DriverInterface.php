<?php
/**
 *
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2016
 *
 * @link      https://www.github.com/janhuang
 * @link      http://www.fast-d.cn/
 */

namespace FastD\Database\Drivers;

use FastD\Database\Query\QueryBuilder;
use FastD\Database\ORM\Model;

/**
 * Interface DriverInterface
 *
 * Driver prototype.
 *
 * @package FastD\Database\Drivers
 */
interface DriverInterface
{
    const DEFAULT_TIMEOUT = 3;
    const DEFAULT_CHARSET = 'utf8';
    
    /**
     * DriverInterface constructor.
     * @param array $config
     */
    public function __construct(array $config);

    /**
     * @return string
     */
    public function getDbName();

    /**
     * @return array
     */
    public function getConfig();

    /**
     * @return \PDO
     */
    public function getPdo();

    /**
     * Transaction callable function.
     *
     * @param callable $callable
     * @return mixed
     */
    public function transaction(callable $callable);

    /**
     * Create SQL query statement.
     *
     * @param $sql
     * @return DriverInterface
     */
    public function query($sql);

    /**
     * Bind pdo parameters.
     *
     * @param array $parameters
     * @return $this
     */
    public function setParameter(array $parameters);

    /**
     * Execute create PDO query statement.
     *
     * @return $this
     */
    public function execute();

    /**
     * @param string|null $field Get field value.
     * @return array|bool
     */
    public function getOne($field = null);

    /**
     * @return array|bool
     */
    public function getAll();

    /**
     * @return int|bool
     */
    public function getId();

    /**
     * @return int|bool
     */
    public function getAffected();

    /**
     * Get table repository object.
     *
     * @param string $model
     * @return Model
     */
    public function getModel($model);

    /**
     * @return QueryBuilder
     */
    public function getQueryBuilder();

    /**
     * @return string
     */
    public function getErrorCode();

    /**
     * @return array
     */
    public function getErrors();

    /**
     * @return array
     */
    public function getLogs();
}