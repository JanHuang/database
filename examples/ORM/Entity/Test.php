<?php

namespace Examples\ORM\Entity;

use FastD\Database\ORM\Entity;

class Test extends Entity
{
    /**
     * @const string
     */
    const PRIMARY = \Examples\ORM\Fields\TestFields::PRIMARY;

    /**
     * Fields const
     * @const array
     */
    const FIELDS = \Examples\ORM\Fields\TestFields::FIELDS;

    /**
     * Fields alias
     * @const array
     */
    const ALIAS = \Examples\ORM\Fields\TestFields::ALIAS;

    /**
     * @var string
     */
    protected $table = 'test';

    /**
     * @var string|null
     */
    protected $repository = 'Examples\ORM\Repository\TestRepository';

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $trueName;

    /**
     * @var string
     */
    protected $nickName;

    /**
     * @var int
     */
    protected $age;

    /**
     * @var int
     */
    protected $gender;

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
     * getTrueName
     *
     * @return string
     */
    public function getTrueName()
    {
        return $this->trueName;
    }

    /**
     * setTrueName
     *
     * @param string $trueName
     * @return $this
     */
    public function setTrueName($trueName)
    {
        $this->trueName = $trueName;

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

    /**
     * getGender
     *
     * @return int
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * setGender
     *
     * @param int $gender
     * @return $this
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }
}