<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/10/22
 * Time: 下午12:08
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Database\ORM;

class Mapping
{
    /**
     * Encapsulates a simple layer of ORM.
     *
     * Insert、Update、Delete or IMPORTQ operation.
     * It's return entity.
     * Get information from this param entity.
     *
     * @param object $entity The found object
     * @return void
     * @throws \InvalidArgumentException
     */
    public function save(&$entity)
    {
        if (!($entity instanceof $this->entity)) {
            throw new \InvalidArgumentException(sprintf('The parameters type should be use "%s"', $this->entity));
        }

        $data = [];

        foreach ($this->fields as $name => $filed) {
            $method = 'get' . ucfirst($name);
            if (null === ($value = $entity->$method())) {
                continue;
            }

            $data[$filed['name']] = $entity->$method();
        }

        if (null === $entity->getId()) {
            $entity->setId($this->insert($data));
            return;
        }

        $this->update($data, ['id' => $entity->getId()]);
    }

    /**
     * @param $entity
     * @return false|int
     */
    public function remove(&$entity)
    {
        if (!($entity instanceof $this->entity)) {
            throw new \InvalidArgumentException(sprintf('The parameters type should be use "%s"', $this->entity));
        }

        return $this->connection->remove($this->getTable(), ['id' => $entity->getId()]);
    }

    /**
     * Fetch all rows.
     *
     * @param array $where
     * @param array|string $field
     * @return object The found object.
     */
    public function findAll(array $where = [],  array $field = [])
    {
        $list = $this->connection->findAll($this->getTable(), $where, $field);

        if (false === $list) {
            return false;
        }

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

    /**
     * Fetch one row.
     *
     * @param array $where
     * @param array $field
     * @return object The found object.
     */
    public function find(array $where = [], array $field = [])
    {
        $row = $this->connection->find($this->getTable(), $where, $field);

        if (false === $row) {
            return false;
        }

        $entity = new $this->entity();

        foreach ($this->keys as $name => $field) {
            $method = 'set' . ucfirst($name);
            $entity->$method(isset($row[$field]) ? $row[$field] : null);
        }

        return $entity;
    }
}