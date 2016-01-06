<?php

namespace Examples\Repository;

use FastD\Database\ORM\Repository;

class ShopContent1ShopRepository extends Repository
{
    /**
     * @const string
     */
    const PRIMARY = \Examples\Fields\ShopContent1ShopFields::PRIMARY;

    /**
     * Fields const
     * @const array
     */
    const FIELDS = \Examples\Fields\ShopContent1ShopFields::FIELDS;

    /**
     * Fields alias
     * @const array
     */
    const ALIAS = \Examples\Fields\ShopContent1ShopFields::ALIAS;

    /**
     * @var string
     */
    protected $table = 'shop_content_1_shop';

    /**
     * @var string|null
     */
    protected $entity = 'Examples\Entity\ShopContent1Shop';


}