<?php

namespace Examples\Fields;

class Test2Fields
{
    /**
     * @const string
     */
    const PRIMARY = 'id';

    /**
     * Const array
     * @const array
     */
     const FIELDS =
array (
  0 => 
  array (
    'alias' => 'id',
    'name' => 'id',
    'length' => '10',
    'notnull' => true,
    'unsigned' => true,
    'default' => '0',
  ),
  1 => 
  array (
    'alias' => 'name',
    'name' => 'name',
    'length' => '20',
    'notnull' => true,
    'unsigned' => false,
    'default' => '',
  ),
  2 => 
  array (
    'alias' => 'nick_name',
    'name' => 'nick_name',
    'length' => '20',
    'notnull' => true,
    'unsigned' => false,
    'default' => '',
  ),
  3 => 
  array (
    'alias' => 'age',
    'name' => 'age',
    'length' => '2',
    'notnull' => true,
    'unsigned' => false,
    'default' => '1',
  ),
);

     /**
      * Const fields alias.
      * @const array
      */
     const ALIAS =
array (
  'id' => 'id',
  'name' => 'name',
  'nick_name' => 'nick_name',
  'age' => 'age',
);

}