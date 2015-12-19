<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/12/18
 * Time: 下午9:47
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Database\ORM\Parser;

use FastD\Database\Drivers\DriverInterface;

class TableParser
{
    protected $info;

    protected $fields;

    protected $create_sql;

    protected $index;

    protected $name;

    public function __construct(DriverInterface $driverInterface, $name)
    {
        $this->name = $name;

        $this->create_sql = $driverInterface
            ->createQuery('SHOW CREATE TABLE `' . $name . '`')
            ->getQuery()
            ->getOne()
        ;

        $this->fields = $driverInterface
            ->createQuery('DESCRIBE `' . $name . '`')
            ->getQuery()
            ->getAll()
        ;

        $this->index = $driverInterface
            ->createQuery('SHOW INDEX FROM `' . $name . '`')
            ->getQuery()
            ->getAll()
        ;

        $this->info = $driverInterface
            ->createQuery('SHOW TABLE STATUS WHERE Name = \'' . $name . '\'')
            ->getQuery()
            ->getOne()
        ;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getFields()
    {
        return $this->fields;
    }

    public function getEngine()
    {
        return $this->index['Engine'];
    }

    public function getCharset()
    {
        return $this->info['Collation'];
    }

    public function getSize()
    {
        return $this->info['Rows'];
    }

    public function getStructure()
    {
        return $this->create_sql;
    }

    public function getIndex()
    {
        return $this->index;
    }

    public function makeAlter()
    {

    }

    public function makeCreate()
    {

    }

    public function makeDrop()
    {}

    public function makeDump()
    {}



    public function compareTableStructure($name, array $fields)
    {

    }
}