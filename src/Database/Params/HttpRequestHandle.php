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

namespace FastD\Database\Params;

use FastD\Http\Request;

/**
 * Class RequestHandle
 *
 * @package FastD\Database\Params
 */
abstract class HttpRequestHandle
{
    const FIELDS    = [];
    const ALIAS     = [];

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var array
     */
    protected $params = [];

    /**
     * @param Request $request
     * @return array
     */
    public function bindRequest(Request $request)
    {
        return $this->bindParams(
            $request->isMethod('get') ? $request->query->all() : $request->request->all()
        );
    }

    /**
     * @param array $params
     * @return array Return request handle parameters.
     * @throws \Exception
     */
    public function bindParams(array $params)
    {
        if (array() === $params) {
            throw new \Exception("Request params error.");
        }

        foreach ($params as $name => $value) {
            if (array_key_exists($name, static::FIELDS)) {
                $field = static::FIELDS[$name];
                // for entity
                $method = 'set' . ucfirst($name);
                if (method_exists($this, $method)) {
                    $this->$method($value);
                }
                // for repository
                $this->data[$field['name']] = ':' . $name;
                $this->params[$name] = $value;
            }
        }
    }
}