<?php

namespace Examples\Fields;

class ShopContent1ShopFields
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
    'unsigned' => false,
    'default' => NULL,
  ),
  1 => 
  array (
    'alias' => 'catid',
    'name' => 'catid',
    'length' => '64',
    'notnull' => true,
    'unsigned' => false,
    'default' => NULL,
  ),
  2 => 
  array (
    'alias' => 'content',
    'name' => 'content',
    'length' => NULL,
    'notnull' => true,
    'unsigned' => false,
    'default' => NULL,
  ),
  3 => 
  array (
    'alias' => 'images',
    'name' => 'images',
    'length' => NULL,
    'notnull' => false,
    'unsigned' => false,
    'default' => NULL,
  ),
  4 => 
  array (
    'alias' => 'price',
    'name' => 'price',
    'length' => NULL,
    'notnull' => false,
    'unsigned' => false,
    'default' => NULL,
  ),
  5 => 
  array (
    'alias' => 'fubiaoti',
    'name' => 'fubiaoti',
    'length' => '255',
    'notnull' => false,
    'unsigned' => false,
    'default' => NULL,
  ),
  6 => 
  array (
    'alias' => 'haoping',
    'name' => 'haoping',
    'length' => '10',
    'notnull' => false,
    'unsigned' => false,
    'default' => NULL,
  ),
  7 => 
  array (
    'alias' => 'yueshouliang',
    'name' => 'yueshouliang',
    'length' => '10',
    'notnull' => false,
    'unsigned' => false,
    'default' => NULL,
  ),
  8 => 
  array (
    'alias' => 'taobaowangzhi',
    'name' => 'taobaowangzhi',
    'length' => '255',
    'notnull' => false,
    'unsigned' => false,
    'default' => NULL,
  ),
  9 => 
  array (
    'alias' => 'dashikaiguang',
    'name' => 'dashikaiguang',
    'length' => '255',
    'notnull' => false,
    'unsigned' => false,
    'default' => NULL,
  ),
  10 => 
  array (
    'alias' => 'zhenshianli',
    'name' => 'zhenshianli',
    'length' => NULL,
    'notnull' => false,
    'unsigned' => false,
    'default' => NULL,
  ),
  11 => 
  array (
    'alias' => 'marketprice',
    'name' => 'marketprice',
    'length' => NULL,
    'notnull' => false,
    'unsigned' => false,
    'default' => NULL,
  ),
  12 => 
  array (
    'alias' => 'alias',
    'name' => 'alias',
    'length' => '255',
    'notnull' => false,
    'unsigned' => false,
    'default' => NULL,
  ),
  13 => 
  array (
    'alias' => 'kucun',
    'name' => 'kucun',
    'length' => '10',
    'notnull' => false,
    'unsigned' => false,
    'default' => NULL,
  ),
  14 => 
  array (
    'alias' => 'jiuneirong',
    'name' => 'jiuneirong',
    'length' => NULL,
    'notnull' => false,
    'unsigned' => false,
    'default' => NULL,
  ),
  15 => 
  array (
    'alias' => 'template',
    'name' => 'template',
    'length' => '120',
    'notnull' => false,
    'unsigned' => false,
    'default' => NULL,
  ),
  16 => 
  array (
    'alias' => 'itemads',
    'name' => 'itemads',
    'length' => NULL,
    'notnull' => false,
    'unsigned' => false,
    'default' => NULL,
  ),
  17 => 
  array (
    'alias' => 'sku',
    'name' => 'sku',
    'length' => '50',
    'notnull' => false,
    'unsigned' => false,
    'default' => NULL,
  ),
  18 => 
  array (
    'alias' => 'ishdfk',
    'name' => 'ishdfk',
    'length' => '3',
    'notnull' => false,
    'unsigned' => false,
    'default' => NULL,
  ),
  19 => 
  array (
    'alias' => 'zodiacopt',
    'name' => 'zodiacopt',
    'length' => NULL,
    'notnull' => false,
    'unsigned' => false,
    'default' => NULL,
  ),
  20 => 
  array (
    'alias' => 'kuanshi',
    'name' => 'kuanshi',
    'length' => NULL,
    'notnull' => false,
    'unsigned' => false,
    'default' => NULL,
  ),
  21 => 
  array (
    'alias' => 'isshowlist',
    'name' => 'isshowlist',
    'length' => '1',
    'notnull' => false,
    'unsigned' => false,
    'default' => NULL,
  ),
  22 => 
  array (
    'alias' => 'hrefurl',
    'name' => 'hrefurl',
    'length' => '255',
    'notnull' => false,
    'unsigned' => false,
    'default' => NULL,
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
  'content' => 'content',
  'images' => 'images',
  'price' => 'price',
  'fubiaoti' => 'fubiaoti',
  'haoping' => 'haoping',
  'yueshouliang' => 'yueshouliang',
  'taobaowangzhi' => 'taobaowangzhi',
  'dashikaiguang' => 'dashikaiguang',
  'zhenshianli' => 'zhenshianli',
  'marketprice' => 'marketprice',
  'alias' => 'alias',
  'kucun' => 'kucun',
  'jiuneirong' => 'jiuneirong',
  'template' => 'template',
  'itemads' => 'itemads',
  'sku' => 'sku',
  'ishdfk' => 'ishdfk',
  'zodiacopt' => 'zodiacopt',
  'kuanshi' => 'kuanshi',
  'isshowlist' => 'isshowlist',
  'hrefurl' => 'hrefurl',
);

}