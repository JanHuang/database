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

use FastD\Console\Command;
use FastD\Console\IO\Input;
use FastD\Console\IO\Output;

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
    }

    public function execute(Input $input, Output $output)
    {
        // TODO: Implement execute() method.
    }
}