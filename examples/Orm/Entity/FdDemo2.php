<?php

namespace Examples\Orm\Entity;

class FdDemo2 extends \FastD\Database\Orm\Entity
{
    /**
     * @const mixed
     */
    const FIELDS = \Examples\Orm\Field\FdDemo2::FIELDS;
    /**
     * @const mixed
     */
    const ALIAS = \Examples\Orm\Field\FdDemo2::ALIAS;
    /**
     * @const mixed
     */
    const PRIMARY = \Examples\Orm\Field\FdDemo2::PRIMARY;
    /**
     * @const mixed
     */
    const TABLE = \Examples\Orm\Field\FdDemo2::TABLE;
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