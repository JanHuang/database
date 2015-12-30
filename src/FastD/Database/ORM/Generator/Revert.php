<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/12/30
 * Time: 下午10:04
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Database\ORM\Generator;

use FastD\Database\Drivers\DriverInterface;
use FastD\Database\ORM\Parser\DBParser;

class Revert
{
    /**
     * @var DBParser
     */
    protected $parser;

    public function __construct(DriverInterface $driverInterface)
    {
        $this->parser = new DBParser($driverInterface);
    }

    public function build($dir, $namespace = '')
    {
        foreach ($this->parser->getTables() as $table) {
            print_r($table);
        }
    }
}