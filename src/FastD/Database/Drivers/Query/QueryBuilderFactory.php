<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 16/1/9
 * Time: 下午1:37
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Database\Drivers\Query;

/**
 * Class QueryBuilderFactory
 *
 * @package FastD\Database\Drivers\Query
 */
abstract class QueryBuilderFactory implements QueryBuilderInterface
{
    /**
     * @var QueryBuilderInterface
     */
    protected static $instance;

    /**
     * @return QueryBuilderInterface
     */
    public static function factory()
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }
}