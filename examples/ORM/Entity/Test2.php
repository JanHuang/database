<?php

namespace Examples\ORM\Entity;

use FastD\Database\ORM\Entity;

class Test2 extends Entity
{
    /**
     * @var string
     */
    protected $table = 'test2';

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
            'type' => 'char',
            'name' => 'nick_name',
            'length'=> 20,
        ],
    ];

    /**
     * @var array
     */
    protected $fields = [
        'id' => 'id','name' => 'trueName','nick_name' => 'nickName'
    ];

    /**
     * @var string|null
     */
    protected $repository = 'Examples\ORM\Repository\Test2Repository';
    
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
}