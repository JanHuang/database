<?php
/**
 *
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2016
 *
 * @link      https://www.github.com/janhuang
 * @link      http://www.fast-d.cn/
 */

namespace FastD\Database\Cache;

/**
 * Interface CacheInterface
 * @package FastD\Database\Cache
 */
interface CacheInterface
{
    /**
     * @return mixed
     */
    public function saveCache();

    /**
     * @return mixed
     */
    public function getCache();

    /**
     * @return mixed
     */
    public function clearCache();
}