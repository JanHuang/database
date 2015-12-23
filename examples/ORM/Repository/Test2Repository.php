<?php

use FastD\Database\ORM\Repository;

class Test2Repository extends Repository
{
    /**
     * @var string
     */
    protected $table = 'test2';

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
            'type' => 'char',
            'name' => 'nick_name',
            'length'=> 20,
        ],
    ];

    /**
     * @var array
     */
    protected $fields = ['id' => 'id','name' => 'trueName','nick_name' => 'nickName'];

    /**
     * @var string
     */
    protected $entity = 'Test2';


}