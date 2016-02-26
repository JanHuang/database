<?php

namespace FastD\Database\Tests\Builder\Orm\Field;

class Demo
{
    /**
     * @const mixed
     */
    const FIELDS = array (
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
  'age' => 
  array (
    'alias' => 'age',
    'name' => 'age',
    'length' => '2',
    'type' => 'smallint',
    'notnull' => false,
    'unsigned' => false,
    'default' => 0,
  ),
  'aa' => 
  array (
    'alias' => 'aa',
    'name' => 'aa',
    'length' => '11',
    'type' => 'int',
    'notnull' => true,
    'unsigned' => false,
    'default' => 0,
  ),
  'fff' => 
  array (
    'alias' => 'fff',
    'name' => 'fff',
    'length' => '11',
    'type' => 'int',
    'notnull' => true,
    'unsigned' => false,
    'default' => 0,
  ),
);
    /**
     * @const mixed
     */
    const ALIAS = array (
  'name' => 'name',
  'age' => 'age',
  'aa' => 'aa',
  'fff' => 'fff',
);
    /**
     * @const mixed
     */
    const PRIMARY = 'age';

}