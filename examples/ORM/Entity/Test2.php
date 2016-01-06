<?php

namespace Examples\Entity;

use FastD\Database\ORM\Entity;

class Test2 extends Entity
{
    /**
     * @const string
     */
    const PRIMARY = \Examples\Fields\Test2Fields::PRIMARY;

    /**
     * Fields const
     * @const array
     */
    const FIELDS = \Examples\Fields\Test2Fields::FIELDS;

    /**
     * Fields alias
     * @const array
     */
    const ALIAS = \Examples\Fields\Test2Fields::ALIAS;

    /**
     * @var string
     */
    protected $table = 'test_2';

    /**
     * @var string|null
     */
    protected $repository = 'Examples\Repository\Test2Repository';

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $nickName;

    /**
     * @var int
     */
    protected $age;

    /**
     * getId
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * setId
     *
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * getName
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * setName
     *
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * getNickName
     *
     * @return string
     */
    public function getNickName()
    {
        return $this->nickName;
    }

    /**
     * setNickName
     *
     * @param string $nickName
     * @return $this
     */
    public function setNickName($nickName)
    {
        $this->nickName = $nickName;

        return $this;
    }

    /**
     * getAge
     *
     * @return int
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * setAge
     *
     * @param int $age
     * @return $this
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }
}