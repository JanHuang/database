<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/9/3
 * Time: 上午2:36
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Database\Command;

use FastD\Config\Config;
use FastD\Console\Command;
use FastD\Console\IO\Input;
use FastD\Console\IO\Output;
use FastD\Database\ORM\Entity\EntityAbstract;

class Builder extends Command
{
    public function getName()
    {
        return 'db:build';
    }

    public function configure()
    {
        $this->setOption('bundle');
        $this->setOption('force');
        $this->setOption('entity');
    }

    public function execute(Input $input, Output $output)
    {
        $config = $this->getEnv()->getContainer()->get('kernel.config');
        $config->load(__DIR__ . '/../../../../bin/yaml/test.yml');
        $this->createEntity($config);
        $config->set([]);
    }

    protected function createEntity(Config $config)
    {
        try {
            $table = $config->get('table');
        } catch (\Exception $e) {
            throw new \RuntimeException('Table name is unset.');
        }

        $suffix = $config->hasGet('suffix', '');
        $prefix = $config->hasGet('prefix', '');
        $charset = $config->hasGet('charset', 'utf8');
        $engine = $config->hasGet('engine', 'innodb');
        $fields = $config->hasGet('fields', []);
        $fullTable = $prefix . $table . $suffix;
        $primary = $config->hasGet('id', []);

        $this->createTableSql($fullTable, $primary, $fields, $charset, $engine);
    }

    protected function createTableSql($table, array $primary, array $fields, $charset = 'utf8', $engine = 'innodb', array $options = [])
    {
        $makeFields = function () use ($primary, $fields) {
            $sql = [];
            $fields = array_merge($primary, $fields);
            foreach ($fields as $key => $value) {
                $length = (array_key_exists('length', $value) ? '(' . $value['length'] . ')' : '');
                $default = (array_key_exists('default', $value) ? ' DEFAULT "' . $value['default'] . '"' : '');
                $comment = (array_key_exists('comment', $value) ? ' COMMENT "' . $value['comment'] . '"' : '');
                $sql[] = "`{$key}` {$value['type']}{$length}{$default}{$comment}";
            }
            return PHP_EOL . implode(',' . PHP_EOL, $sql) . PHP_EOL;
        };
        $sql = sprintf('
CREATE TABLE `%s` (%s) CHARSET=%s ENGINE=%s;
        ', $table, $makeFields(), $charset, $engine);

        echo $sql;
    }

    protected function createRepository(EntityAbstract $entityAbstract)
    {

    }
}