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

    protected $entity = ' = '
namespace Deme\Repository;
\Entity\Test'';
}