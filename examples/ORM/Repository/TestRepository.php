<?php

namespace Examples\ORM\Repository;

use FastD\Database\ORM\Repository;

class TestRepository extends Repository
{
    /**
     * @const string
     */
    const PRIMARY = \Examples\ORM\Fields\TestFields::PRIMARY;

    /**
     * Fields const
     * @const array
     */
    const FIELDS = \Examples\ORM\Fields\TestFields::FIELDS;

    /**
     * Fields alias
     * @const array
     */
    const ALIAS = \Examples\ORM\Fields\TestFields::ALIAS;

    /**
     * @var string
     */
    protected $table = 'test';

    /**
     * @var string|null
     */
    protected $entity = 'Examples\ORM\Entity\Test';


}