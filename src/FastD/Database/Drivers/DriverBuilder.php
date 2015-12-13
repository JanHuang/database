<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/12/13
 * Time: 下午11:23
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Database\Drivers;

/**
 * Class DriverBuilder
 *
 * @package FastD\Database\Drivers
 */
class DriverBuilder
{
    /**
     * @param array $config
     * @return MySQL
     */
    public static function createDriver(array $config)
    {
        switch ($config['database_type']) {
            case 'mariadb':
            case 'mysql':
            default:
                return new MySQL($config);
        }
    }
}