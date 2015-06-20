<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/6/15
 * Time: 下午9:50
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Database;

/**
 * Class Config
 *
 * @package FastD\Database
 */
class Config
{
    /**
     * @var array
     */
    protected $config = [
        'database_type'     => 'mysql',
        'database_host'     => '127.0.0.1',
        'database_port'     => '3306',
        'database_user'     => 'root',
        'database_pwd'      => '',
        'database_name'     => '',
        'database_charset'  => 'utf8',
        'database_prefix'   => '',
        'database_suffix'   => '',
        'database_options'  => [],
    ];

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = array_merge($this->config, $config);
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->config['database_options'];
    }

    /**
     * @return string
     */
    public function getDatabaseType()
    {
        return $this->config['database_type'];
    }
    /**
     * @return string
     */
    public function getDatabaseHost()
    {
        return $this->config['database_host'];
    }

    /**
     * @return string
     */
    public function getDatabasePort()
    {
        return $this->config['database_port'];
    }

    /**
     * @return string
     */
    public function getDatabaseUser()
    {
        return $this->config['database_user'];
    }

    /**
     * @return string
     */
    public function getDatabasePwd()
    {
        return $this->config['database_pwd'];
    }

    /**
     * @return string
     */
    public function getDatabaseName()
    {
        return $this->config['database_name'];
    }

    /**
     * @return string
     */
    public function getDatabaseCharset()
    {
        return $this->config['database_charset'];
    }

    /**
     * @return string
     */
    public function getDatabasePrefix()
    {
        return $this->config['database_prefix'];
    }

    /**
     * @return string
     */
    public function getDatabaseSuffix()
    {
        return $this->config['database_suffix'];
    }

    /**
     * @return string
     */
    public function getDsn()
    {
        switch ($this->getDatabaseType()) {
            case 'pgsql':
                $dsn = sprintf('pgsql:host=%s;port=%s;dbname=%s', $this->getDatabaseHost(), $this->getDatabasePort(), $this->getDatabaseName());
                break;
            case 'sybase':
                $dsn = sprintf('dblib:host=%s;port=%s;dbname=%s', $this->getDatabaseHost(), $this->getDatabasePort(), $this->getDatabaseName());
                break;
            case 'mariadb':
            case 'mysql':
            default:
                $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s', $this->getDatabaseHost(), $this->getDatabasePort(), $this->getDatabaseName());
        }

        return $dsn;
    }
}