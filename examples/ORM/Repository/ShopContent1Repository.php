<?php

namespace Examples\Repository;

use FastD\Database\ORM\Repository;

class ShopContent1Repository extends Repository
{
    /**
     * @const string
     */
    const PRIMARY = \Examples\Fields\ShopContent1Fields::PRIMARY;

    /**
     * Fields const
     * @const array
     */
    const FIELDS = \Examples\Fields\ShopContent1Fields::FIELDS;

    /**
     * Fields alias
     * @const array
     */
    const ALIAS = \Examples\Fields\ShopContent1Fields::ALIAS;

    /**
     * @var string
     */
    protected $table = 'shop_content_1';

    /**
     * @var string|null
     */
    protected $entity = 'Examples\Entity\ShopContent1';


}