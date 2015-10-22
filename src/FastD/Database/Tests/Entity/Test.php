<?php

namespace Deme\Entity;

class Test
{
    /**
     * @var string|null
     */
    protected $repository = 'Deme\Repository\TestRepository';
    
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