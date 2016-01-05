<?php

namespace Examples\Entity;

use FastD\Database\ORM\Entity;

class Test extends Entity
{
    /**
     * @const string
     */
    const PRIMARY = \Examples\Fields\TestFields::PRIMARY;

    /**
     * Fields const
     * @const array
     */
    const FIELDS = \Examples\Fields\TestFields::FIELDS;

    /**
     * Fields alias
     * @const array
     */
    const ALIAS = \Examples\Fields\TestFields::ALIAS;

    /**
     * @var string
     */
    protected $table = 'test';

    /**
     * @var string|null
     */
    protected $repository = 'Examples\Repository\TestRepository';

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $nickName;

    /**
     * @var int
     */
    protected $age;

    /**
     * @var string
     */
    protected $trueName;

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
     * getId
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
     * getNickName
     *
     * @return string
     */
    public function getNickName()
    {
        return $this->nickName;
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
     * getAge
     *
     * @return int
     */
    public function getAge()
    {
        return $this->age;
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

    public function testExists()
    {
        
    }

    public function ssa(){}
}