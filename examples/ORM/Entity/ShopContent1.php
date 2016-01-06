<?php

namespace Examples\Entity;

use FastD\Database\ORM\Entity;

class ShopContent1 extends Entity
{
    /**
     * @const string
     */
    const PRIMARY = \Examples\Fields\ShopContent1Fields::PRIMARY;

    /**
     * Fields const
     * @const array
     */
    const FIELDS = \Examples\Fields\ShopContent1Fields::FIELDS;

    /**
     * Fields alias
     * @const array
     */
    const ALIAS = \Examples\Fields\ShopContent1Fields::ALIAS;

    /**
     * @var string
     */
    protected $table = 'shop_content_1';

    /**
     * @var string|null
     */
    protected $repository = 'Examples\Repository\ShopContent1Repository';

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $catid;

    /**
     * @var int
     */
    protected $modelid;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $thumb;

    /**
     * @var string
     */
    protected $keywords;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var int
     */
    protected $listorder;

    /**
     * @var int
     */
    protected $status;

    /**
     * @var int
     */
    protected $hits;

    /**
     * @var int
     */
    protected $sysadd;

    /**
     * @var int
     */
    protected $userid;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var mixed
     */
    protected $inputtime;

    /**
     * @var mixed
     */
    protected $updatetime;

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
     * getCatid
     *
     * @return string
     */
    public function getCatid()
    {
        return $this->catid;
    }

    /**
     * setCatid
     *
     * @param string $catid
     * @return $this
     */
    public function setCatid($catid)
    {
        $this->catid = $catid;

        return $this;
    }

    /**
     * getModelid
     *
     * @return int
     */
    public function getModelid()
    {
        return $this->modelid;
    }

    /**
     * setModelid
     *
     * @param int $modelid
     * @return $this
     */
    public function setModelid($modelid)
    {
        $this->modelid = $modelid;

        return $this;
    }

    /**
     * getTitle
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * setTitle
     *
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * getThumb
     *
     * @return string
     */
    public function getThumb()
    {
        return $this->thumb;
    }

    /**
     * setThumb
     *
     * @param string $thumb
     * @return $this
     */
    public function setThumb($thumb)
    {
        $this->thumb = $thumb;

        return $this;
    }

    /**
     * getKeywords
     *
     * @return string
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * setKeywords
     *
     * @param string $keywords
     * @return $this
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;

        return $this;
    }

    /**
     * getDescription
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * setDescription
     *
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * getUrl
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * setUrl
     *
     * @param string $url
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * getListorder
     *
     * @return int
     */
    public function getListorder()
    {
        return $this->listorder;
    }

    /**
     * setListorder
     *
     * @param int $listorder
     * @return $this
     */
    public function setListorder($listorder)
    {
        $this->listorder = $listorder;

        return $this;
    }

    /**
     * getStatus
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * setStatus
     *
     * @param int $status
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * getHits
     *
     * @return int
     */
    public function getHits()
    {
        return $this->hits;
    }

    /**
     * setHits
     *
     * @param int $hits
     * @return $this
     */
    public function setHits($hits)
    {
        $this->hits = $hits;

        return $this;
    }

    /**
     * getSysadd
     *
     * @return int
     */
    public function getSysadd()
    {
        return $this->sysadd;
    }

    /**
     * setSysadd
     *
     * @param int $sysadd
     * @return $this
     */
    public function setSysadd($sysadd)
    {
        $this->sysadd = $sysadd;

        return $this;
    }

    /**
     * getUserid
     *
     * @return int
     */
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * setUserid
     *
     * @param int $userid
     * @return $this
     */
    public function setUserid($userid)
    {
        $this->userid = $userid;

        return $this;
    }

    /**
     * getUsername
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * setUsername
     *
     * @param string $username
     * @return $this
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * getInputtime
     *
     * @return mixed
     */
    public function getInputtime()
    {
        return $this->inputtime;
    }

    /**
     * setInputtime
     *
     * @param mixed $inputtime
     * @return $this
     */
    public function setInputtime($inputtime)
    {
        $this->inputtime = $inputtime;

        return $this;
    }

    /**
     * getUpdatetime
     *
     * @return mixed
     */
    public function getUpdatetime()
    {
        return $this->updatetime;
    }

    /**
     * setUpdatetime
     *
     * @param mixed $updatetime
     * @return $this
     */
    public function setUpdatetime($updatetime)
    {
        $this->updatetime = $updatetime;

        return $this;
    }
}