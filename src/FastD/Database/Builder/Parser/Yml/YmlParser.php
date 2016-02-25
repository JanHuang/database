<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 16/2/25
 * Time: 下午4:33
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Database\ORM\Generator\Parser\Yml;

use Symfony\Component\Yaml\Yaml;

class YmlParser
{
    protected $yml;

    protected $fields = [];

    public function __construct($yml)
    {
        if (!file_exists($yml)) {
            throw new \InvalidArgumentException(sprintf('Yml ["%s"] is not such found.', $yml));
        }

        $this->yml = Yaml::parse(file_get_contents($yml));

        $this->fields = $this->yml['fields'] ?? [];
    }

    public function getTable()
    {
        return $this->yml['table'];
    }

    public function getEngine()
    {
        return $this->yml['engine'] ?? 'innodb';
    }

    public function getCharset()
    {
        return $this->yml['charset'] ?? 'utf8';
    }

    public function getFields()
    {
        return $this->fields;
    }
}