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
        'nickname' => [
            'type' => 'varchar',
            'name' => 'nickname',
        ],
        'catId' => [
            'type' => 'int',
            'name' => 'category_id',
        ],
        'trueName' => [
            'type' => 'varchar',
            'name' => 'true_name',
        ],
    ];

    protected $keys = [
        'id' => 'id','nickname' => 'nickname','catId' => 'category_id','trueName' => 'true_name'
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
    protected $nickname;

    /**
     * @var int
     */
    protected $catId;

    /**
     * @var string
     */
    protected $trueName;

    
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
     * @param string $nickname
     * @return $this
     */
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;

        return $this;
    }

    /**
     * @return string
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * @param int $catId
     * @return $this
     */
    public function setCatId($catId)
    {
        $this->catId = $catId;

        return $this;
    }

    /**
     * @return int
     */
    public function getCatId()
    {
        return $this->catId;
    }

    /**
     * @param string $trueName
     * @return $this
     */
    public function setTrueName($trueName)
    {
        $this->trueName = $trueName;

        return $this;
    }

    /**
     * @return string
     */
    public function getTrueName()
    {
        return $this->trueName;
    }

}