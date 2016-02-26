<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 16/2/18
 * Time: 下午3:58
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Database;

/**
 * Class DriverError
 *
 * @package FastD\Database
 */
class DriverError extends \Exception
{
    /**
     * DriverError constructor.
     * @param array $errorInfo
     */
    public function __construct(array $errorInfo)
    {
        parent::__construct($errorInfo[2], $errorInfo[1], new \Exception($errorInfo[0]));
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return "[Msg]: {$this->getMessage()}. [Code]: {$this->getCode()}";
    }
}