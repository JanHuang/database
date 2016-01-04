<?php

namespace Repository;

use FastD\Database\ORM\Repository;

class TestRepository extends Repository
{
    /**
     * @var string
     */
    protected $table = 'test';

    
    /**
     * @const string
     */
    const PRIMARY = \Fields\TestFields::PRIMARY;

    /**
     * Fields const
     * @const array
     */
    const FIELDS = \Fields\TestFields::FIELDS;

    /**
     * Fields alias
     * @const array
     */
    const ALIAS = \Fields\TestFields::ALIAS;

    /**
     * @var string
     */
    protected $entity = 'Entity\Test';
}