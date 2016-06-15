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
 * Class Builder
 *
 * @package FastD\Database\Builder
 */
abstract class Builder
{
    /**
     * @param null|int $flag
     * @return string
     */
    abstract public function toSql($flag = null);

    /**
     * @param null|int $flag
     * @return string
     */
    abstract public function toYml($flag = null);

    /**
     * @param $name
     * @return mixed|string
     */
    public function rename($name)
    {
        if (strpos($name, '_')) {
            $arr = explode('_', $name);
            $name = array_shift($arr);
            foreach ($arr as $value) {
                $name .= ucfirst($value);
            }
        }
        return $name;
    }
}