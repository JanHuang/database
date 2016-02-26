<?php

namespace FastD\Database\Tests\Builder\Orm\Entity;

class Fd_demo2 extends \FastD\Database\Orm\Entity
{
    /**
     * @const mixed
     */
    const FIELDS = \FastD\Database\Tests\Builder\Orm\Field\Fd_demo2::FIELDS;
    /**
     * @const mixed
     */
    const ALIAS = \FastD\Database\Tests\Builder\Orm\Field\Fd_demo2::ALIAS;
    /**
     * @const mixed
     */
    const PRIMARY = \FastD\Database\Tests\Builder\Orm\Field\Fd_demo2::PRIMARY;
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