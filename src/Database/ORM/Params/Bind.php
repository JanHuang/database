<?php
/**
 *
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2016
 *
 * @link      https://www.github.com/janhuang
 * @link      http://www.fast-d.cn/
 */

namespace FastD\Database\ORM\Params;

use FastD\Http\Request;

/**
 * Trait Bind
 *
 * @package FastD\Database\ORM\Params
 */
trait Bind
{
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
     * @return $this
     */
    public function bindRequest(Request $request)
    {
        return $this->bindParams(
            $request->isMethod('get')
                ?
                $request->query->all()
                : $request->request->all()
        );
    }

    /**
     * @param array $params
     * @return $this
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
                $method = 'set' . ucfirst($name);
                if (method_exists($this, $method)) {
                    $this->$method($value);
                }
                $this->data[$field['name']] = ':' . $name;
                $this->params[$name] = $value;
            }
        }

        return $this;
    }
}