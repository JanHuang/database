<?php

namespace Test;

class Test extends \FastD\Database\ORM\Entity
{
    /**
     * @var mixed
     */
    protected $id;

    /**
     * @const mixed
     */
    const FIELDS = \Test\Test::FIELDS;

    /**
     * @const mixed
     */
    const ALIAS = \Test\Test::ALIAS;

    /**
     * @const mixed
     */
    const TABLE = \Test\Test::TABLE;

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