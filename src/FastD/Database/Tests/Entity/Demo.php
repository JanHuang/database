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
    protected $categoryId;

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
     * @param int $categoryId
     * @return $this
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;

        return $this;
    }

    /**
     * @return int
     */
    public function getCategoryId()
    {
        return $this->categoryId;
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