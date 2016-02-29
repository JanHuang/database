<?php

namespace FastD\Database\Tests\Builder\Orm\Entity;

class Demo2 extends \FastD\Database\Orm\Entity implements \ArrayAccess
{
    /**
     * @const mixed
     */
    const FIELDS = \FastD\Database\Tests\Builder\Orm\Field\Demo2::FIELDS;

    /**
     * @const mixed
     */
    const ALIAS = \FastD\Database\Tests\Builder\Orm\Field\Demo2::ALIAS;

    /**
     * @const mixed
     */
    const PRIMARY = \FastD\Database\Tests\Builder\Orm\Field\Demo2::PRIMARY;

    /**
     * @const mixed
     */
    const TABLE = \FastD\Database\Tests\Builder\Orm\Field\Demo2::TABLE;

    /**
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