<?php

namespace Demo\Repository;

use FastD\Database\ORM\Repository\Repository;

class DemoRepository extends Repository
{
    protected $struct = [
        'id' => [
            'type' => 'int',
            'name' => 'id',
        ],
        'id' => [
            'type' => 'int',
            'name' => 'id',
        ],
        'nickname' => [
            'type' => 'varchar',
            'name' => 'nickname',
        ],
        'category_id' => [
            'type' => 'int',
            'name' => 'category_id',
        ],
        'true_name' => [
            'type' => 'varchar',
            'name' => 'true_name',
        ],
    ];

    protected $keys = ['id', 'id', 'nickname', 'category_id', 'true_name'];
}