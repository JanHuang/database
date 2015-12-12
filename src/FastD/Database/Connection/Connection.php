<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/12/12
 * Time: 下午7:26
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Database\Connection;

/**
 * Class Connection
 *
 * @package FastD\Database\Connection
 */
abstract class Connection implements ConnectionInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var \PDO
     */
    protected $pdo;

    /**
     * @var \PDOStatement
     */
    protected $statement;

    /**
     * @return \PDOStatement
     */
    public function getStatement()
    {
        return $this->statement;
    }

    /**
     * @param \PDOStatement $statement
     * @return $this
     */
    public function setStatement(\PDOStatement $statement)
    {
        $this->statement = $statement;

        return $this;
    }

    /**
     * @param \PDO $PDO
     * @return $this
     */
    public function setPDO(\PDO $PDO)
    {
        $this->pdo = $PDO;

        return $this;
    }

    /**
     * @return \PDO
     */
    public function getPDO()
    {
        return $this->pdo;
    }

    /**
     * @param $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Close pdo connection.
     */
    public function close()
    {
        $this->pdo = null;
        $this->statement = null;
    }

    public function __destruct()
    {
        $this->close();
    }
}