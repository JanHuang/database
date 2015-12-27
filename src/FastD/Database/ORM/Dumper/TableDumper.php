<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/12/27
 * Time: 下午10:42
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Database\ORM\Dumper;

use FastD\Database\ORM\Parser\DBParser;

/**
 * Class TableDumper
 *
 * @package FastD\Database\ORM\Dumper
 */
class TableDumper
{
    /**
     * @var DBParser
     */
    protected $parser;

    /**
     * TableDumper constructor.
     *
     * @param DBParser $parser
     */
    public function __construct(DBParser $parser)
    {
        $this->parser = $parser;
    }
}