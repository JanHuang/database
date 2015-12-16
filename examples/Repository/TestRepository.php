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
    protected $structure = [
        'id' => [
            'type' => 'int',
            'name' => 'id',
        ],
        'trueName' => [
            'type' => 'varchar',
            'name' => 'name',
        ],
    ];

    /**
     * @var array
     */
    protected $fields = ['id' => 'id','name' => 'trueName'];

    /**
     * @var string
     */
    protected $entity = 'Examples\Entity\Test';


}