<?php

namespace Deme\Repository;

use FastD\Database\ORM\Repository;

class DemoRepository extends Repository
{
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

    protected $keys = ['id', 'nickname', 'catId', 'trueName'];

    protected $entity = 'Deme\Entity\Demo';
}