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
     * @var DriverInterface
     */
    protected $driver;

    /**
     * @var Table[]
     */
    protected $tables = [];

    /**
     * Parser constructor.
     * @param DriverInterface|null $driverInterface
     */
    public function __construct(DriverInterface $driverInterface = null)
    {
        $this->driver = $driverInterface;

        if (null !== $driverInterface) {
            $this->getTablesByDb();
        }
    }

    /**
     * @return \FastD\Database\Builder\Table[]
     */
    public function getTablesByDb()
    {
        if (empty($this->tables)) {

            $db = $this->driver->query('SELECT database() as db;')->execute()->getOne('db');

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
                    $length = 0;
                    if (false !== strpos($type, '(')) {
                        $length = substr($type, strpos($type, '(') + 1, -1);
                        $type = substr($type, 0, strpos($type, '('));
                    }

                    $field = new Field(
                        $value['field'],
                        $type,
                        $length,
                        '',
                        $value['nullable'] == 'NO' ? false : true,
                        $value['default'],
                        $value['comment']
                    );
                    $field
                        ->setExtra($value['extra'])
                        ->setKey($value['key'])
                    ;

                    $fields[] = $field;
                }

                $this->tables[$name] = new Table($name, $fields);
            }
        }

        return $this->tables;
    }

    /**
     * @param $name
     * @return Table|null
     */
    public function getTableByDb($name)
    {
        return $this->tables[$name] ?? null;
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
            $fields[$alias] = new Field(
                $field['name'],
                $field['type'] ?? 'varchar',
                $field['length'] ?? 255,
                $alias,
                $field['nullable'] ?? false,
                $field['default'] ?? '',
                $field['comment'] ?? ''
            );
        }

        $table->setFields($fields);

        return $table;
    }
}