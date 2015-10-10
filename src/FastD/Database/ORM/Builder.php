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

    public function getSturct()
    {
        return $this->structs;
    }

    public function addStruct(array $structs)
    {
        $this->structs[] = $structs;

        return $this;
    }

    public function setStruct(array $strusts)
    {
        $this->structs = $strusts;

        return $this;
    }

    public function checkTableStatus()
    {}

    public function buildSql()
    {
        foreach ($this->getSturct() as $struct) {

        }
    }

    public function buildEntity()
    {}

    public function buildRepository()
    {

    }
}