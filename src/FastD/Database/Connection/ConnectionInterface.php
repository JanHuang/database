<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/2/8
 * Time: 上午12:02
 * Github: https://www.github.com/janhuang 
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 */

namespace FastD\Database\Connection;
use FastD\Database\Entity\EntityInterface;

/**
 * Interface ConnectionInterface
 *
 * @package FastD\Database\Connection
 */
interface ConnectionInterface
{
    /**
     * Constructor.
     * Initialize database connection.
     *
     * @param string $dsn The connection dsn.
     * @param string $user The connection username.
     * @param string $password The connection user password.
     * @param string $charset The connection default charset.
     * @param array  $options The connection initialize execute options array.
     *
     * @api
     */
    public function __construct($dsn, $user, $password, $charset = 'utf8', array $options = []);

    /**
     * Start database transaction.
     *
     * @return bool
     */
    public function beginTransaction();

    /**
     * Commit database transaction.
     *
     * @return bool
     */
    public function commit();

    /**
     * Transaction error. Transaction rollback.
     *
     * @return bool
     */
    public function rollback();

    /**
     * @param $dql
     * @return $this
     */
    public function prepare($dql);

    /**
     * Bind prepare value. But the name is no has ':'.
     *
     * @param        $name
     * @param string $value
     * @return $this
     */
    public function setParameters($name, $value = '');

    /**
     * @return $this
     */
    public function getQuery();

    /**
     * @return array|bool
     */
    public function getAll();

    /**
     * @param string $name
     * @return array|bool
     */
    public function getOne($name = null);

    /**
     * @return int|false
     */
    public function getAffectedRow();

    /**
     * @return int|false
     */
    public function getLastId();

    /**
     * Get connection detail information.
     *
     * @return array|bool
     */
    public function getConnectionInfo();

    /**
     * Get connection operation error information.
     *
     * @return array
     */
    public function getErrors();

    /**
     * @return array
     */
    public function getSql();

    /**
     * @return array
     */
    public function getLogs();

    /**
     * @return mixed
     */
    public function close();
}