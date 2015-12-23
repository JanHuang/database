<?php

namespace Examples\ORM\Entity;

use FastD\Database\ORM\Entity;

class Test extends Entity
{
    /**
     * @var string
     */
    protected $table = 'test';

    /**
     * @var array
     */
    protected $structure = [
        'id' => [
            'type' => 'int',
            'name' => 'id',
            'length'=> 10,
        ],
        'trueName' => [
            'type' => 'char',
            'name' => 'name',
            'length'=> 20,
        ],
        'nickName' => [
            'type' => 'varchar',
            'name' => 'nick_name',
            'length'=> 20,
        ],
        'age' => [
            'type' => 'smallint',
            'name' => 'age',
            'length'=> 2,
        ],
    ];

    /**
     * @var array
     */
    protected $fields = [
        'id' => 'id','name' => 'trueName','nick_name' => 'nickName','age' => 'age'
    ];

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
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $nickName
     * @return $this
     */
    public function setNickName($nickName)
    {
        $this->nickName = $nickName;

        return $this;
    }

    /**
     * @return string
     */
    public function getNickName()
    {
        return $this->nickName;
    }

    /**
     * @param int $age
     * @return $this
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * @return int
     */
    public function getAge()
    {
        return $this->age;
    }
}