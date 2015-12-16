<?php

namespace Examples\Repository;

use FastD\Database\ORM\Repository;

class TestRepository extends Repository
{
    /**
     * @var string
     */
    protected $table = 'test';

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
    protected $entity = 'Examples\Entity\Test';


}