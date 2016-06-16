<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/12/13
 * Time: 上午11:09
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
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
     * @return array
     */
    public function getErrors();

    /**
     * @return array
     */
    public function getLogs();
}