<?php

namespace Examples\Fields;

class ShopContent1Fields
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
    'alias' => 'catid',
    'name' => 'catid',
    'length' => '255',
    'notnull' => true,
    'unsigned' => false,
    'default' => '0',
  ),
  2 => 
  array (
    'alias' => 'modelid',
    'name' => 'modelid',
    'length' => '5',
    'notnull' => true,
    'unsigned' => false,
    'default' => '0',
  ),
  3 => 
  array (
    'alias' => 'title',
    'name' => 'title',
    'length' => '80',
    'notnull' => true,
    'unsigned' => false,
    'default' => NULL,
  ),
  4 => 
  array (
    'alias' => 'thumb',
    'name' => 'thumb',
    'length' => '255',
    'notnull' => true,
    'unsigned' => false,
    'default' => NULL,
  ),
  5 => 
  array (
    'alias' => 'keywords',
    'name' => 'keywords',
    'length' => '40',
    'notnull' => true,
    'unsigned' => false,
    'default' => NULL,
  ),
  6 => 
  array (
    'alias' => 'description',
    'name' => 'description',
    'length' => NULL,
    'notnull' => true,
    'unsigned' => false,
    'default' => NULL,
  ),
  7 => 
  array (
    'alias' => 'url',
    'name' => 'url',
    'length' => '100',
    'notnull' => true,
    'unsigned' => false,
    'default' => NULL,
  ),
  8 => 
  array (
    'alias' => 'listorder',
    'name' => 'listorder',
    'length' => '3',
    'notnull' => false,
    'unsigned' => true,
    'default' => NULL,
  ),
  9 => 
  array (
    'alias' => 'status',
    'name' => 'status',
    'length' => '2',
    'notnull' => true,
    'unsigned' => true,
    'default' => '1',
  ),
  10 => 
  array (
    'alias' => 'hits',
    'name' => 'hits',
    'length' => '5',
    'notnull' => false,
    'unsigned' => true,
    'default' => '0',
  ),
  11 => 
  array (
    'alias' => 'sysadd',
    'name' => 'sysadd',
    'length' => '1',
    'notnull' => true,
    'unsigned' => false,
    'default' => '0',
  ),
  12 => 
  array (
    'alias' => 'userid',
    'name' => 'userid',
    'length' => '8',
    'notnull' => true,
    'unsigned' => false,
    'default' => '0',
  ),
  13 => 
  array (
    'alias' => 'username',
    'name' => 'username',
    'length' => '20',
    'notnull' => true,
    'unsigned' => false,
    'default' => NULL,
  ),
  14 => 
  array (
    'alias' => 'inputtime',
    'name' => 'inputtime',
    'length' => '10',
    'notnull' => true,
    'unsigned' => true,
    'default' => '0',
  ),
  15 => 
  array (
    'alias' => 'updatetime',
    'name' => 'updatetime',
    'length' => '10',
    'notnull' => true,
    'unsigned' => true,
    'default' => '0',
  ),
);

     /**
      * Const fields alias.
      * @const array
      */
     const ALIAS =
array (
  'id' => 'id',
  'catid' => 'catid',
  'modelid' => 'modelid',
  'title' => 'title',
  'thumb' => 'thumb',
  'keywords' => 'keywords',
  'description' => 'description',
  'url' => 'url',
  'listorder' => 'listorder',
  'status' => 'status',
  'hits' => 'hits',
  'sysadd' => 'sysadd',
  'userid' => 'userid',
  'username' => 'username',
  'inputtime' => 'inputtime',
  'updatetime' => 'updatetime',
);

}