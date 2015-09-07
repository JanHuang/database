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

        try {
            $suffix = $config->get('suffix');
        } catch (\Exception $e) {
            $suffix = '';
        }

        try {
            $prefix = $config->get('prefix');
        } catch (\Exception $e) {
            $prefix = '';
        }

        $fullTable = $prefix . $table . $suffix;
        $fields = $config->get('fields');
    }

    protected function createTableSql()
    {
        return '
CREATE TABLE `%s` (%s) CHARSET=%s ENGINE=%s;
        ';
    }

    protected function createRepository(EntityAbstract $entityAbstract)
    {}
}