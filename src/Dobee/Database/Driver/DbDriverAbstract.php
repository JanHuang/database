<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/6/18
 * Time: 下午6:33
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace Dobee\Database\Driver;

use Dobee\Database\Repository\Repository;

abstract class DbDriverAbstract implements DriverInterface
{
    protected $repositories;
    /**
     * @param $repository
     * @return Repository
     */
    public function getRepository($repository)
    {
        if (isset($this->repositories[$repository])) {
            return $this->repositories[$repository];
        }

        if (false !== strpos($repository, ':')) {
            $repository = str_replace(':', '\\', $repository);
        }
        $name = $repository;
        $repository .= 'Repository';
        $repository = new $repository();
        if ($repository instanceof Repository) {
            $repository
                ->setConnection($this)
                ->setPrefix($this->getPrefix())
            ;
            if (null === $repository->getTable()) {
                $repository->setTable($this->parseTableName($name));
            }
        }
        return $repository;
    }
}