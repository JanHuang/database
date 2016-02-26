<?php

namespace Examples\Orm\Field;

class Demo2
{
    /**
     * @const mixed
     */
    const FIELDS = array (
  'id' => 
  array (
    'alias' => 'id',
    'name' => 'id',
    'length' => '10',
    'type' => 'int',
    'notnull' => false,
    'unsigned' => false,
    'default' => 0,
  ),
);
    /**
     * @const mixed
     */
    const ALIAS = array (
  'id' => 'id',
);
    /**
     * @const mixed
     */
    const PRIMARY = 'id';
    /**
     * @const mixed
     */
    const TABLE = 'fd_demo2_fd2';

}