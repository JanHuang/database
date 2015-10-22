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

namespace FastD\Database\ORM\Generator;

/**
 * Class Builder
 *
 * @package FastD\Database\ORM\Mapper
 */
class Builder
{
    /**
     * @var array
     */
    protected $structs = [];

    /**
     * @return StructBuilder[]
     */
    public function getSturct()
    {
        return $this->structs;
    }

    /**
     * @param array $structs
     * @return $this
     */
    public function addStruct(array $structs)
    {
        $this->structs[] = new StructBuilder($structs);

        return $this;
    }

    /**
     * @param array $strusts
     * @return $this
     */
    public function setStruct(array $strusts)
    {
        foreach ($strusts as $strust) {
            $this->addStruct($strust);
        }

        return $this;
    }

    public function checkTableStatus()
    {}

    /**
     * @return array
     */
    public function buildSql()
    {
        $sql = [];

        foreach ($this->getSturct() as $struct) {
            $sql[$struct->getTable()] = $struct->makestructsQL();
        }

        return $sql;
    }

    /**
     * @param        $dir
     * @param string $namespace
     */
    public function buildEntity($dir, $namespace = '')
    {
        foreach ($this->getSturct() as $struct) {
            $entity = new EntityBuilder($struct, $dir);
            $entity->buildEntity($namespace . $struct->getTable());
        }
    }
}