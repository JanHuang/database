<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 16/2/25
 * Time: 下午10:47
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Database\Builder;

use FastD\Database\DriverInterface;
use Symfony\Component\Yaml\Yaml;

/**
 * Class Parser
 *
 * @package FastD\Database\Builder\Parser
 */
class Parser
{
    /**
     * @var bool
     */
    private $parse_in_db = false;

    /**
     * @var bool
     */
    private $parse_in_dir = false;

    /**
     * @var DriverInterface
     */
    protected $driver;

    /**
     * @var Table[]
     */
    protected $tables_in_db = [];

    /**
     * @var Table[]
     */
    protected $table_in_yml = [];

    /**
     * @var null|string
     */
    protected $dir;

    /**
     * Parser constructor.
     * @param DriverInterface|null $driverInterface
     * @param string $dir Yml configuration directory path.
     */
    public function __construct(DriverInterface $driverInterface = null, $dir = null)
    {
        $this->driver = $driverInterface;

        $this->dir = $dir;

        if (null !== $driverInterface) {
            $this->parseTablesInDB();
        }

        if (null !== $dir) {
            $this->parseTablesInDir();
        }
    }

    /**
     * @return void
     */
    protected function parseTablesInDB()
    {
        if (false === $this->parse_in_db) {
            $db = $this->driver->query('SELECT database() as db;')->execute()->getOne('db');
            $config = $this->driver->getConfig();
            $prefix = isset($config['database_prefix']) ? $config['database_prefix'] : '';
            $suffix = isset($config['database_suffix']) ? $config['database_suffix'] : '';

            $tables = $this->driver
                ->query('SHOW TABLES;')
                ->execute()
                ->getAll();

            foreach ($tables as $table) {
                $name = array_pop($table);

                $schemes = $this->driver
                    ->query(
                        'SELECT
  TABLE_SCHEMA AS `db_name`,
  TABLE_NAME AS `table_name`,
  COLUMN_NAME AS `field`,
  COLUMN_DEFAULT AS `default`,
  IS_NULLABLE AS `nullable`,
  COLUMN_TYPE AS `type`,
  COLUMN_COMMENT AS `comment`,
  COLUMN_KEY AS `key`,
  EXTRA AS `extra`
FROM information_schema.COLUMNS
WHERE
  TABLE_NAME = \'' . $name . '\'
  AND TABLE_SCHEMA = \'' . $db . '\';'
                    )
                    ->execute()
                    ->getAll();

                $fields = [];

                foreach ($schemes as $item => $value) {
                    $type = $value['type'];
                    $pattern = '/(?<type>\w+)\(?(?<length>\d*)\)?\s?(?<unsigned>\w*)?/';
                    preg_match($pattern, $type, $match);

                    $field = new Field(
                        $value['field'],
                        $match['type'],
                        (int) $match['length'],
                        '',
                        $value['nullable'] == 'NO' ? false : true,
                        $value['default'],
                        $value['comment']
                    );

                    $field->setUnsigned($match['unsigned']);

                    $field
                        ->setExtra($value['extra'])
                    ;

                    switch ($value['key']) {
                        case 'PRI':
                            $field->setKey(new Key($value['field'], Key::KEY_PRIMARY));
                            break;
                        case 'MUL':
                            $field->setKey(new Key($value['field'], Key::KEY_INDEX));
                            break;
                        case 'UNI':
                            $field->setKey(new Key($value['field'], Key::KEY_UNIQUE));
                            break;
                    }

                    $fields[] = $field;
                }

                $table = new Table($name, $fields);

                if (!empty($prefix) && false !== ($index = strpos($name, $prefix))) {
                    $len = strlen($prefix);
                    $name = substr($name, $len);
                    $table->setPrefix($prefix);
                }

                if (!empty($suffix) && false !== ($index = strpos($name, $suffix))) {
                    $name = substr($name, 0, $index);
                    $table->setSuffix($suffix);
                }

                $table->setTable($name);

                $this->tables_in_db[$name] = $table;
            }

            $this->parse_in_db = true;
        }
    }

    /**
     * @return void
     */
    protected function parseTablesInDir()
    {
        if (!is_dir($this->dir)) {
            throw new \InvalidArgumentException(sprintf('Directory ["%s"] is no such.', $this->dir));
        }

        if (false === $this->parse_in_dir) {
            if ($dh = opendir($this->dir)) {
                while (($file = readdir($dh)) !== false) {
                    if ('yml' != pathinfo($file, PATHINFO_EXTENSION)) {
                        continue;
                    }

                    $table = $this->getTableByYml($this->dir . '/' . $file);

                    $this->table_in_yml[$table->getTable()] = $table;
                }

                closedir($dh);

                $this->parse_in_dir = true;
            }
        }
    }

    /**
     * @return Table[]
     */
    public function getTables()
    {
        return array_merge($this->tables_in_db, $this->table_in_yml);
    }

    /**
     * @return Table[]
     */
    public function getTablesByDb()
    {
        return $this->tables_in_db;
    }

    /**
     * @param $name
     * @return Table|null
     */
    public function getTableByDb($name)
    {
        return $this->tables_in_db[$name] ?? null;
    }

    /**
     * @return Table[]
     */
    public function getTablesByYml()
    {
        return $this->table_in_yml;
    }

    /**
     * @param $yml
     * @return Table
     */
    public function getTableByYml($yml)
    {
        if (!file_exists($yml)) {
            throw new \InvalidArgumentException(sprintf('File ["%s"] is not found.', $yml));
        }

        $content = Yaml::parse(file_get_contents($yml));

        $table = new Table($content['table']);

        $table->setCharset($content['charset'] ?? 'utf8');
        $table->setEngine($content['engine'] ?? 'InnoDB');
        $table->setPrefix($content['prefix'] ?? '');
        $table->setSuffix($content['suffix'] ?? '');

        $fields = [];

        foreach ($content['fields'] as $alias => $field) {
            $f = new Field(
                $field['name'],
                $field['type'] ?? 'varchar',
                $field['length'] ?? 255,
                $alias,
                $field['nullable'] ?? false,
                $field['default'] ?? '',
                $field['comment'] ?? ''
            );

            if (isset($field['key'])) {
                switch (strtoupper($field['key'])) {
                    case 'PRIMARY':
                        $key = new Key($field['name'], Key::KEY_PRIMARY);
                        break;
                    case 'UNIQUE':
                        $key = new Key($field['name'], Key::KEY_UNIQUE);
                        break;
                    case 'FULLTEXT':
                        $key = new Key($field['name'], Key::KEY_FULLTEXT);
                        break;
                    case 'INDEX':
                    default:
                        $key = new Key($field['name'], Key::KEY_INDEX);
                }

                $f->setKey($key);
            }

            $fields[$alias] = $f;
        }

        $table->setFields($fields);

        return $table;
    }
}