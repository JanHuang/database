<?php

namespace Deme\Repository;

use FastD\Database\ORM\Repository;

class TestRepository extends Repository
{
    protected $fields = [
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

    protected $keys = ['nickname', 'catId', 'trueName'];

    protected $entity = 'Deme\Entity\Test';
}