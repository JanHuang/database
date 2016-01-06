<?php

namespace Examples\Repository;

use FastD\Database\ORM\Repository;

class Test2Repository extends Repository
{
    /**
     * @const string
     */
    const PRIMARY = \Examples\Fields\Test2Fields::PRIMARY;

    /**
     * Fields const
     * @const array
     */
    const FIELDS = \Examples\Fields\Test2Fields::FIELDS;

    /**
     * Fields alias
     * @const array
     */
    const ALIAS = \Examples\Fields\Test2Fields::ALIAS;

    /**
     * @var string
     */
    protected $table = 'test_2';

    /**
     * @var string|null
     */
    protected $entity = 'Examples\Entity\Test2';


}