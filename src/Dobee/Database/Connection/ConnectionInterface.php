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

namespace Dobee\Database\Connection;

use Dobee\Database\Repository\Repository;
use Dobee\Database\Config;

/**
 * Interface ConnectionInterface
 *
 * @package Dobee\Database\Connection
 */
interface ConnectionInterface
{
    /**
     * Constructor.
     * Sub database module config.
     *
     * @param Config $config
     */
    public function __construct(Config $config);

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
     * @return array
     */
    public function getResult();

    /**
     * @return array|bool
     */
    public function info();

    /**
     * @return array
     */
    public function error();

    /**
     * @return mixed
     */
    public function close();
}