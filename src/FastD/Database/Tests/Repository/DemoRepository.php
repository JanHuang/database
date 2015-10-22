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
        'category_id' => [
            'type' => 'int',
            'name' => 'category_id',
        ],
        'true_name' => [
            'type' => 'varchar',
            'name' => 'true_name',
        ],
    ];

    protected $keys = ['id', 'nickname', 'category_id', 'true_name'];

    protected $entity = ' = '
namespace Deme\Repository;
\Entity\Demo'';
}