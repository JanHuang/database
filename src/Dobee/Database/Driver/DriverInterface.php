<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/6/15
 * Time: 下午3:33
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace Dobee\Database\Driver;

/**
 * Interface DriverInterface
 *
 * @package Dobee\Database\Driver
 */
interface DriverInterface
{
    /**
     * @param DriverConfig $config
     */
    public function __construct(DriverConfig $config);

    /**
     * Start database transaction.
     * {@inheritdoc}
     *
     * @throws \PDOException
     * @return bool
     *
     * @api
     */
    public function beginTransaction();

    /**
     * @return bool
     *
     * @api
     */
    public function commit();

    /**
     * @return bool
     *
     * @api
     */
    public function rollback();

    /**
     * @return string
     *
     * @api
     */
    public function error();

    /**
     * @return array
     *
     * @api
     */
    public function logs();

    /**
     * @param $sql
     * @return $this
     *
     * @api
     */
    public function bind($sql);

    /**
     * @param array $parameters
     * @return $this
     *
     * @api
     */
    public function setParameters(array $parameters);

    /**
     * @return $this
     *
     * @api
     */
    public function getQuery();

    /**
     * @return array|bool
     *
     * @api
     */
    public function getResult();
}