<?php

namespace Demo\Entity;

class Demo
{
    /**
     * @var string|null
     */
    protected $repository = 'Demo\Repository\DemoRepository';
    
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
     * @var int
     */
    protected $id;

    /**
     * @param int $id
     */
    public function __construct($id = null)
    {
        $this->primary = $id;
    }
    
    /**
     * @param string nickname
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
     * @param int categoryId
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
     * @param string trueName
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