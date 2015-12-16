<?php

namespace Examples\Entity;


use FastD\Database\ORM\Entity;

class Test extends Entity
{
    /**
     * @var string
     */
    protected $table = 'test';

    protected $fields = [
        'id' => [
            'type' => 'int',
            'name' => 'id',
        ],
        'name' => [
            'type' => 'varchar',
            'name' => 'name',
        ],
    ];

    protected $keys = [
        'id' => 'id','name' => 'name'
    ];

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
    protected $name;

    
    /**
     * @param int $id
     * @param \FastD\Database\Drivers\DriverInterface $driverInterface
     */
    public function __construct($id = null, \FastD\Database\Drivers\DriverInterface $driverInterface = null)
    {
        $this->id = $id;

        $this->setDriver($driverInterface);
    }
    
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

}