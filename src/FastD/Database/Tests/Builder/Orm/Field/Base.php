<?php

namespace FastD\Database\Tests\Builder\Orm\Field;

class Base
{
    /**
     * @const mixed
     */
    const FIELDS = array (
  'id' => 
  array (
    'alias' => 'id',
    'name' => 'id',
    'length' => '11',
    'type' => 'int',
    'notnull' => false,
    'unsigned' => false,
    'default' => 0,
  ),
  'name' => 
  array (
    'alias' => 'name',
    'name' => 'name',
    'length' => '20',
    'type' => 'varchar',
    'notnull' => false,
    'unsigned' => false,
    'default' => '',
  ),
  'content' => 
  array (
    'alias' => 'content',
    'name' => 'content',
    'length' => 0,
    'type' => 'text',
    'notnull' => true,
    'unsigned' => false,
    'default' => NULL,
  ),
  'createAt' => 
  array (
    'alias' => 'createAt',
    'name' => 'create_at',
    'length' => '40',
    'type' => 'varchar',
    'notnull' => false,
    'unsigned' => false,
    'default' => '',
  ),
);

    /**
     * @const mixed
     */
    const ALIAS = array (
  'id' => 'id',
  'name' => 'name',
  'content' => 'content',
  'create_at' => 'createAt',
);

    /**
     * @const mixed
     */
    const PRIMARY = 'id';

    /**
     * @const mixed
     */
    const TABLE = 'base';

}