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
     * @const string
     */
    const PRIMARY = \Examples\Fields\TestFields::PRIMARY;

    /**
     * Fields const
     * @const array
     */
    const FIELDS = \Examples\Fields\TestFields::FIELDS;

    /**
     * Fields alias
     * @const array
     */
    const ALIAS = \Examples\Fields\TestFields::ALIAS;

    /**
     * @var string
     */
    protected $entity = 'Examples\Entity\Test';
}