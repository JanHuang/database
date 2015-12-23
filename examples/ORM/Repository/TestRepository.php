<?php

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
            'length'=> 10,
        ],
        'trueName' => [
            'type' => 'char',
            'name' => 'name',
            'length'=> 20,
        ],
        'nickName' => [
            'type' => 'varchar',
            'name' => 'nick_name',
            'length'=> 20,
        ],
        'age' => [
            'type' => 'smallint',
            'name' => 'age',
            'length'=> 2,
        ],
    ];

    /**
     * @var array
     */
    protected $fields = ['id' => 'id','name' => 'trueName','nick_name' => 'nickName','age' => 'age'];

    /**
     * @var string
     */
    protected $entity = 'Test';


}