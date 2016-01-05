<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/12/24
 * Time: 上午12:15
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Database\ORM;

use FastD\Http\Request;

/**
 * Class RequestHandle
 *
 * @package FastD\Database\ORM
 */
class HttpRequestHandle
{
    const FIELDS    = [];

    /**
     * @var array
     */
    protected $data;

    /**
     * @var array
     */
    protected $params;

    /**
     * @param Request $request
     * @return array
     */
    public function bindRequest(Request $request)
    {
        return $this->bindRequestParams(
            $request->isMethod('get') ? $request->query->all() : $request->request->all()
        );
    }

    /**
     * @param array $params
     * @return array Return request handle parameters.
     * @throws \Exception
     */
    public function bindRequestParams(array $params)
    {
        if (array() === $params) {
            throw new \Exception("Request params error.");
        }
        foreach ($params as $name => $value) {
            if (array_key_exists($name, static::FIELDS)) {
                if (strlen($value) > static::FIELDS[$name]['length']) {
                    throw new \Exception("Params length invalid.");
                }
                $name = static::FIELDS[$name]['name'];
                $this->data[$name] = ':' . $name;
                $this->params[$name] = $value;
            }
        }
    }
}