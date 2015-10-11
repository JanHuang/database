<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/10/11
 * Time: 上午1:13
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Database\ORM;

class Builder
{
    protected $structs = [];

    /**
     * @return Struct[]
     */
    public function getSturct()
    {
        return $this->structs;
    }

    public function addStruct(array $structs)
    {
        $this->structs[] = new Struct($structs);

        return $this;
    }

    public function setStruct(array $strusts)
    {
        foreach ($strusts as $strust) {
            $this->addStruct($strust);
        }

        return $this;
    }

    public function checkTableStatus()
    {}

    public function buildSql()
    {
        $sql = [];

        foreach ($this->getSturct() as $struct) {
            $sql[] = $struct->makeStructSQL();
        }

        return $sql;
    }

    public function buildEntity()
    {

    }

    public function buildRepository()
    {

    }
}