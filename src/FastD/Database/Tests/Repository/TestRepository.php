<?php

namespace Deme\Repository;

use FastD\Database\ORM\Repository;

class TestRepository extends Repository
{
    protected $table = 'test';

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

    protected $keys = ['nickname' => 'nickname','catId' => 'category_id','trueName' => 'true_name'];

    protected $entity = 'Deme\Entity\Test';
}