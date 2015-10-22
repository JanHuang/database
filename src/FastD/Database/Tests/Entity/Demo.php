<?php

namespace Deme\Entity;

class Demo
{
    /**
     * @var string|null
     */
    protected $repository = 'Deme\Repository\DemoRepository';
    
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
     */
    public function __construct($id = null)
    {
        $this->id = $id;
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