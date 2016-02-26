<?php

namespace FastD\Database\Tests\Builder\Orm\Entity;

class Demo extends \FastD\Database\Orm\Entity
{
    /**
     * @const mixed
     */
    const FIELDS = \FastD\Database\Tests\Builder\Orm\Field\Demo::FIELDS;
    /**
     * @const mixed
     */
    const ALIAS = \FastD\Database\Tests\Builder\Orm\Field\Demo::ALIAS;
    /**
     * @const mixed
     */
    const PRIMARY = \FastD\Database\Tests\Builder\Orm\Field\Demo::PRIMARY;
    /**
     * @const mixed
     */
    const TABLE = \FastD\Database\Tests\Builder\Orm\Field\Demo::TABLE;
    /*
     * @var mixed
     */
    protected $name;
    /*
     * @var mixed
     */
    protected $age;
    /*
     * @var mixed
     */
    protected $aa;
    /*
     * @var mixed
     */
    protected $fff;
    /*
     * @var mixed
     */
    protected $id;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
    /**
     * @return mixed
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * @param mixed $age
     * @return $this
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }
    /**
     * @return mixed
     */
    public function getAa()
    {
        return $this->aa;
    }

    /**
     * @param mixed $aa
     * @return $this
     */
    public function setAa($aa)
    {
        $this->aa = $aa;

        return $this;
    }
    /**
     * @return mixed
     */
    public function getFff()
    {
        return $this->fff;
    }

    /**
     * @param mixed $fff
     * @return $this
     */
    public function setFff($fff)
    {
        $this->fff = $fff;

        return $this;
    }
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