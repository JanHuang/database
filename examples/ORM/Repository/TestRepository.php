<?php

namespace Examples\Repository;

use FastD\Database\ORM\Repository;

class TestRepository extends Repository
{
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
    protected $table = 'test';

    /**
     * @var string|null
     */
    protected $entity = 'Examples\Entity\Test';

    /**
     * test
     */
    public function test()
    {}
}