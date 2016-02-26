<?php

namespace Examples\Orm\Repository;

class BaseRepository extends \FastD\Database\Orm\Repository
{
    /**
     * @const mixed
     */
    const FIELDS = \Examples\Orm\Field\Base::FIELDS;
    /**
     * @const mixed
     */
    const ALIAS = \Examples\Orm\Field\Base::ALIAS;
    /**
     * @const mixed
     */
    const PRIMARY = \Examples\Orm\Field\Base::PRIMARY;
    /**
     * @const mixed
     */
    const TABLE = \Examples\Orm\Field\Base::TABLE;

}