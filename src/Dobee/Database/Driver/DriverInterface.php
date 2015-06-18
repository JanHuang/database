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

use Dobee\Database\Config;
use Dobee\Database\Query\QueryContext;
use Dobee\Database\Repository\Repository;

/**
 * Interface DriverInterface
 *
 * @package Dobee\Database\Driver
 */
interface DriverInterface
{
    /**
     * @param Config $config
     */
    public function __construct(Config $config);

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
     */
    public function getSql();

    /**
     * @return string
     *
     * @api
     */
    public function error();

    /**
     * @return string
     *
     * @api
     */
    public function log();

    /**
     * @return array
     */
    public function info();

    /**
     * @param       $table
     * @param array $where
     * @param array $fields
     * @return array
     */
    public function find($table, array $where = [], array $fields = ['*']);

    /**
     * @param       $table
     * @param array $where
     * @param array $fields
     * @return array
     */
    public function findAll($table, array $where = [], array $fields = ['*']);

    /**
     * @param $sql
     * @return $this
     *
     * @api
     */
    public function createQuery($sql);

    /**
     * @param mixed $name
     * @param mixed $value
     * @return $this
     *
     * @api
     */
    public function setParameters($name, $value = null);

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

    /**
     * @param $repository
     * @return Repository
     */
    public function getRepository($repository);

    /**
     * @param       $table
     * @param array $data
     * @return int|bool
     */
    public function insert($table, array $data = array());

    /**
     * @param       $table
     * @param array $data
     * @param array $where
     * @return int|bool
     */
    public function update($table, array $data = array(), array $where = array());

    /**
     * @param       $table
     * @param array $where
     * @return int|bool
     */
    public function delete($table, array $where = array());

    /**
     * @param       $table
     * @param array $where
     * @return int|bool
     */
    public function count($table, array $where = array());

    /**
     * @param       $table
     * @param array $where
     * @return int|bool
     */
    public function has($table, array $where = array());
}