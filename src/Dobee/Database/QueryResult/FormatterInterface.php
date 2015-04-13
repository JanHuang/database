<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/4/13
 * Time: 下午12:04
 * Github: https://www.github.com/janhuang 
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 */

namespace Dobee\Database\QueryResult;

/**
 * Interface FormatterInterface
 *
 * @package Dobee\Database\QueryResult
 */
interface FormatterInterface
{
    /**
     * @return array
     */
    public function toArray();

    /**
     * @return string
     */
    public function toJson();

    /**
     * @return \ArrayObject
     */
    public function toObject();

    /**
     * @return string
     */
    public function toString();

    /**
     * @return string
     */
    public function toSerialize();
}