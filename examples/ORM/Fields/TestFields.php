<?php

namespace Examples\ORM\Fields;

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
    'length' => '10',
    'notnull' => true,
    'unsigned' => true,
    'default' => NULL,
  ),
  1 => 
  array (
    'alias' => 'trueName',
    'name' => 'true_name',
    'length' => '20',
    'notnull' => true,
    'unsigned' => false,
    'default' => '',
  ),
  2 => 
  array (
    'alias' => 'telNumber',
    'name' => 'tel_number',
    'length' => '20',
    'notnull' => true,
    'unsigned' => false,
    'default' => NULL,
  ),
  3 => 
  array (
    'alias' => 'nickName',
    'name' => 'nick_name',
    'length' => '20',
    'notnull' => true,
    'unsigned' => false,
    'default' => '',
  ),
  4 => 
  array (
    'alias' => 'age',
    'name' => 'age',
    'length' => '2',
    'notnull' => true,
    'unsigned' => false,
    'default' => '1',
  ),
  5 => 
  array (
    'alias' => 'gender',
    'name' => 'gender',
    'length' => '1',
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
  'true_name' => 'trueName',
  'tel_number' => 'telNumber',
  'nick_name' => 'nickName',
  'age' => 'age',
  'gender' => 'gender',
);

}