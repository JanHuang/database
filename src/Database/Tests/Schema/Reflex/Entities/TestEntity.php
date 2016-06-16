<?php

namespace Test\Entities;

class TestEntity extends \FastD\Database\ORM\Entity implements \ArrayAccess
{
    /**
     * @var mixed
     */
    protected $id;

    /**
     * @const mixed
     */
    const FIELDS = \Test\Fields\Test::FIELDS;

    /**
     * @const mixed
     */
    const ALIAS = \Test\Fields\Test::ALIAS;

    /**
     * @const mixed
     */
    const TABLE = \Test\Fields\Test::TABLE;

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