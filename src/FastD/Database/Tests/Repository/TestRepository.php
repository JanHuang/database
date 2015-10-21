<?php

namespace Test\Repository;

use FastD\Database\ORM\Repository\Repository;

class TestRepository extends Repository
{
    protected $struct = [
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

    protected $keys = ['nickname', 'category_id', 'true_name'];
}