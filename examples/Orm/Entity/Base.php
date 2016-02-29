<?php

namespace Examples\Orm\Entity;

class Base extends \FastD\Database\Orm\Entity implements \ArrayAccess
{
    /**
     * @const mixed
     */
    const FIELDS = \Examples\Orm\Field\Base::FIELDS;

    /**
     * @const mixed
     */
    const ALIAS = \Examples\Orm\Field\Base::ALIAS;

    /**
     * @const mixed
     */
    const PRIMARY = \Examples\Orm\Field\Base::PRIMARY;

    /**
     * @const mixed
     */
    const TABLE = \Examples\Orm\Field\Base::TABLE;

    /**
     * @var mixed
     */
    protected $id;

    /**
     * @var mixed
     */
    protected $name;

    /**
     * @var mixed
     */
    protected $content;

    /**
     * @var mixed
     */
    protected $createAt;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     * @return $this
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreateAt()
    {
        return $this->createAt;
    }

    /**
     * @param mixed $createAt
     * @return $this
     */
    public function setCreateAt($createAt)
    {
        $this->createAt = $createAt;

        return $this;
    }
}