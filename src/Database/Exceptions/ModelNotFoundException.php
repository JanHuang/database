<?php
/**
 *
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2016
 *
 * @link      https://www.github.com/janhuang
 * @link      http://www.fast-d.cn/
 */

namespace Database\Exceptions;

use Exception;

class ModelNotFoundException extends Exception
{
    public function __construct($name)
    {
        parent::__construct(sprintf('Model ["%s"] is not found.', $name));
    }
}