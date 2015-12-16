<?php

namespace Examples\Repository;

use FastD\Database\ORM\Repository;

class TestRepository extends Repository
{
    /**
     * @var string
     */
    protected $table = 'demo';

    /**
     * @var array
     */
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

    /**
     * @var array
     */
    protected $keys = ['id' => 'id','nickname' => 'nickname','catId' => 'category_id','trueName' => 'true_name'];

    /**
     * @var string
     */
    protected $entity = 'Examples\Entity\Demo';

    /**
     * ORM auto create "remove" method.
     *
     * @param \Examples\Entity\Demo $entity
     * @return int
     */
    public function remove(\Examples\Entity\Demo $entity)
    {
        return $this->connection->remove($this->getTable(), ['id' => $entity->getId()]);
    }

    /**
     * ORM auto create "save" method.
     * Encapsulates a simple layer of ORM.
     *
     * Insert、Update、Delete or IMPORTQ operation.
     * It's return entity.
     * Get information from this param entity.
     *
     * @param \Examples\Entity\Demo $entity The found object
     * @return $this
     */
    public function save(\Examples\Entity\Demo $entity)
    {
        $data = [];

        foreach ($this->keys as $name => $filed) {
            $method = 'get' . ucfirst($name);
            if (null === ($value = $entity->$method())) {
                continue;
            }

            $data[$filed] = $entity->$method();
        }

        if (null === $entity->getId()) {
            $entity->setId($this->insert($data));
        } else {
            $this->update($data, ['id' => $entity->getId()]);
        }
    }

    /**
     * ORM auto create "find" method.
     * Fetch one row.
     *
     * @param array $where
     * @param array $fields
     * @return \Examples\Entity\Demo
     */
    public function find(array $where = [], array $fields = [])
    {
        $row = parent::find($where, $fields);

        $entity = new $this->entity();
        foreach ($this->keys as $name => $field) {
            $method = 'set' . ucfirst($name);
            $entity->$method(isset($row[$field]) ? $row[$field] : null);
        }

        return $entity;
    }

    /**
     * ORM auto create "findAll" method.
     *
     * Fetch all rows.
     *
     * @param array $where
     * @param array|string $field
     * @return \Examples\Entity\Demo[]
     */
    public function findAll(array $where = [],  array $field = [])
    {
        $list = parent::findAll($where, $field);

        $entities = [];
        foreach ($list as $row) {
            $entity = new $this->entity();
            foreach ($this->keys as $name => $field) {
                $method = 'set' . ucfirst($name);
                $entity->$method(isset($row[$field]) ? $row[$field] : null);
            }
            $entities[] = $entity;
        }

        return $entities;
    }
}