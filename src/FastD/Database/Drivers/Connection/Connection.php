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

namespace FastD\Database\Drivers\Connection;

/**
 * Class Connection
 *
 * @package FastD\Database\Connection
 */
class Connection implements ConnectionInterface
{
    /**
     * @var \PDO
     */
    protected $pdo;

    /**
     * @var \PDOStatement
     */
    protected $statement;

    /**
     * Connection constructor.
     *
     * @param \PDO $PDO
     */
    public function __construct(\PDO $PDO)
    {
        $this->setPDO($PDO);
    }

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
     * Start database transaction.
     *
     * @return bool
     */
    public function begin()
    {
        return $this->pdo->beginTransaction();
    }

    /**
     * Commit database transaction.
     *
     * @return bool
     */
    public function commit()
    {
        return $this->pdo->commit();
    }

    /**
     * Transaction error. Transaction rollback.
     *
     * @return bool
     */
    public function rollback()
    {
        return $this->pdo->rollBack();
    }

    /**
     * @param \Closure $closure
     * @return bool
     */
    public function transaction(\Closure $closure)
    {
        $this->begin();

        if ($closure()) {
            return $this->commit();
        }

        return $this->rollback();
    }

    /**
     * @param        $name
     * @param string $value
     * @return $this
     */
    public function setParameters($name, $value = null)
    {
        $this->statement->bindParam(':' . $name, $value);

        return $this;
    }

    /**
     * @param $sql
     * @return $this
     */
    public function prepare($sql)
    {
        $this->statement = $this->pdo->prepare($sql);

        return $this;
    }

    /**
     * @return $this
     */
    public function getQuery()
    {
        $this->statement->execute();

        return $this;
    }

    /**
     * @return array
     */
    public function getAll()
    {
        $result = $this->statement->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    /**
     * @param null $name
     * @return mixed
     */
    public function getOne($name = null)
    {
        $result = $this->statement->fetch(\PDO::FETCH_ASSOC);

        return null === $name ? $result : $result[$name];
    }

    /**
     * @return int|false
     */
    public function getAffectedRow()
    {
        $row = $this->statement->rowCount();

        return $row;
    }

    /**
     * @return int|false
     */
    public function getLastId()
    {
        return $this->pdo->lastInsertId();
    }


    /**
     * @return array|bool
     */
    public function getColumn()
    {
        // TODO: Implement getColumn() method.
    }

    /**
     * @return int|bool
     */
    public function getCount()
    {
        // TODO: Implement getCount() method.
    }

    /**
     * Get connection operation error information.
     *
     * @return array
     */
    public function getErrors()
    {
        return null === $this->statement ? $this->pdo->errorInfo() : $this->statement->errorInfo();
    }

    /**
     * Get connection detail information.
     *
     * @return string
     */
    public function getConnectionInfo()
    {
        $attributes = '';

        foreach ([
                     'pdo'               => 'DRIVER_NAME',
                     'client version'    => 'CLIENT_VERSION',
                     'connection status' => 'CONNECTION_STATUS',
                     'server info'       => 'SERVER_INFO',
                     'server version'    => 'SERVER_VERSION',
                 ] as $name => $value) {
            $attributes .= $name . ': ' . $this->pdo->getAttribute(constant('\PDO::ATTR_' . $value)) . PHP_EOL;
        }

        return $attributes;
    }

    

    /**
     * @return void
     */
    public function close()
    {
        $this->pdo = null;
        $this->statement = null;
    }

    /**
     * Connection destruct. Destroy db connection.
     */
    public function __destruct()
    {
        $this->close();
    }
}