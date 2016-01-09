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

use FastD\Database\Drivers\Query\Paging\Pagination;
use FastD\Database\ORM\Repository;
use FastD\Database\Drivers\Query\QueryBuilderInterface;

/**
 * Interface DriverInterface
 *
 * @package FastD\Database\Drivers
 */
interface DriverInterface
{
    /**
     * @param $name
     * @return DriverInterface
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getName();

    /**
     * @return \PDO
     */
    public function getPDO();

    /**
     * @param \PDO $PDO
     * @return DriverInterface
     */
    public function setPDO(\PDO $PDO);

    /**
     * @return \PDOStatement
     */
    public function getPDOStatement();

    /**
     * @param \PDOStatement $PDOStatement
     * @return $this
     */
    public function setPDOStatement(\PDOStatement $PDOStatement);

    /**
     * Create SQL query statement.
     *
     * @param $sql
     * @return DriverInterface
     */
    public function createQuery($sql);

    /**
     * Execute create PDO query statement.
     *
     * @return $this
     */
    public function getQuery();

    /**
     * Bind pdo parameters.
     *
     * @param array|string $name
     * @param $value
     * @return $this
     */
    public function setParameter($name, $value = null);

    /**
     * @param string|null $name
     * @return array|bool
     */
    public function getOne($name = null);

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
     * @param string $repository
     * @return Repository
     */
    public function getRepository($repository);

    /**
     * @return array
     */
    public function getErrors();
}