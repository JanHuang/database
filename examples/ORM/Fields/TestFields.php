<?php

namespace Examples\Fields;

class TestFields
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
    'length' => 10,
    'notnull' => false,
    'unsigned' => true,
    'default' => 0,
  ),
  1 => 
  array (
    'alias' => 'trueName',
    'name' => 'name',
    'length' => 20,
    'notnull' => true,
    'unsigned' => false,
    'default' => '',
  ),
  2 => 
  array (
    'alias' => 'nickName',
    'name' => 'nick_name',
    'length' => 20,
    'notnull' => true,
    'unsigned' => false,
    'default' => '',
  ),
  3 => 
  array (
    'alias' => 'age',
    'name' => 'age',
    'length' => 2,
    'notnull' => true,
    'unsigned' => false,
    'default' => 1,
  ),
);

     /**
      * Const fields alias.
      * @const array
      */
     const ALIAS =
array (
  'id' => 'id',
  'name' => 'trueName',
  'nick_name' => 'nickName',
  'age' => 'age',
);

}