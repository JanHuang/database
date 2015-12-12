<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/12/12
 * Time: 下午12:01
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Database\ORM;

use FastD\Database\Connection\ConnectionInterface;

class Entity
{
    protected $primary_key;

    protected $connection;

    public function __construct($primaryKey, ConnectionInterface $connection = null)
    {
        $this->primary_key = $primaryKey;

        $this->connection = $connection;
    }

    /**
     * Save row in database.
     */
    public function flush()
    {}

    /**
     * Remove row in database.
     */
    public function remove()
    {}
}