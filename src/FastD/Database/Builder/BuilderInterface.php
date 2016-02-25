<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 16/2/25
 * Time: 下午5:33
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Database\Builder;

/**
 * Interface BuilderInterface
 * @package FastD\Database\Builder
 */
interface BuilderInterface
{
    /**
     * @param null|int $flag
     * @return string
     */
    public function toSql($flag = null);

    /**
     * @param null|int $flag
     * @return string
     */
    public function toYml($flag = null);
}