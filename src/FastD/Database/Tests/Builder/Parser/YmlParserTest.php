<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 16/2/25
 * Time: 下午9:57
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Database\Tests\Builder\Parser;

use FastD\Database\Builder\Parser;

class YmlParserTest extends \PHPUnit_Framework_TestCase
{
    public function testYml()
    {
        $parser = new Parser();

        $table = $parser->getTableByYml(__DIR__ . '/../Yml/demo.yml');
    }
}