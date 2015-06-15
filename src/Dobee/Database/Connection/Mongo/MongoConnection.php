<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/4/27
 * Time: 下午5:47
 * Github: https://www.github.com/janhuang 
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 */

namespace Dobee\Database\Connection\Mongo;

use Dobee\Database\Connection\ConnectionInterface;
use Dobee\Database\Connection\DbConnection;
use Dobee\Database\Driver\DriverConfig;
use Dobee\Database\Driver\MongoDriver;
use Dobee\Database\Repository\Repository;

class MongoConnection extends DbConnection
{
    protected function createConnectionDriverSocket(array $config, array $options = [])
    {
        return new MongoDriver(new DriverConfig($config, $options));
    }
}