<?php

namespace Examples\Orm\Entity;

class Demo2 extends \FastD\Database\Orm\Entity
{
    /**
     * @const mixed
     */
    const FIELDS = \Examples\Orm\Field\Demo2::FIELDS;
    /**
     * @const mixed
     */
    const ALIAS = \Examples\Orm\Field\Demo2::ALIAS;
    /**
     * @const mixed
     */
    const PRIMARY = \Examples\Orm\Field\Demo2::PRIMARY;
    /**
     * @const mixed
     */
    const TABLE = \Examples\Orm\Field\Demo2::TABLE;
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