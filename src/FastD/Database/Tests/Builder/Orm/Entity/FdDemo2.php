<?php

namespace FastD\Database\Tests\Builder\Orm\Entity;

class FdDemo2 extends \FastD\Database\Orm\Entity
{
    /**
     * @const mixed
     */
    const FIELDS = \FastD\Database\Tests\Builder\Orm\Field\FdDemo2::FIELDS;
    /**
     * @const mixed
     */
    const ALIAS = \FastD\Database\Tests\Builder\Orm\Field\FdDemo2::ALIAS;
    /**
     * @const mixed
     */
    const PRIMARY = \FastD\Database\Tests\Builder\Orm\Field\FdDemo2::PRIMARY;
    /**
     * @const mixed
     */
    const TABLE = \FastD\Database\Tests\Builder\Orm\Field\FdDemo2::TABLE;
    /*
     * @var mixed
     */
    protected $id;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

}