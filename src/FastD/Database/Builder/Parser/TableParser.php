<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/12/18
 * Time: 下午9:47
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Database\ORM\Parser;

use FastD\Database\Drivers\DriverInterface;

/**
 * Class TableParser
 *
 * @package FastD\Database\ORM\Parser
 */
class TableParser
{
    use NameParseTrait;

    /**
     * @var array|bool
     */
    protected $info;

    /**
     * @var FieldParser[]
     */
    protected $new_fields = [];

    /**
     * @var FieldParser[]
     */
    protected $fields = [];

    /**
     * @var array|bool
     */
    protected $create_sql;

    /**
     * @var array|bool
     */
    protected $index;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var bool
     */
    protected $exists = false;

    /**
     * @var string
     */
    protected $primary;

    /**
     * TableParser constructor.
     *
     * @param DriverInterface $driverInterface
     * @param                 $name
     * @param array           $fields
     * @param bool            $isExists
     */
    public function __construct(DriverInterface $driverInterface, $name, array $fields = [], $isExists = false)
    {
        $this->name = $name;

        $this->exists = $isExists;

        if ($isExists) {
            $this->parseExistsTable($driverInterface, $name);
        } else {
            $this->parseNotExistsTable($fields);
        }
    }

    /**
     * @param DriverInterface $driverInterface
     * @param                 $name
     */
    protected function parseExistsTable(DriverInterface $driverInterface, $name)
    {
        $this->create_sql = $driverInterface
            ->createQuery('SHOW CREATE TABLE `'.$name.'`')
            ->getQuery()
            ->getOne();

        $this->index = $driverInterface
            ->createQuery('SHOW INDEX FROM `'.$name.'`')
            ->getQuery()
            ->getAll();

        $this->info = $driverInterface
            ->createQuery('SHOW TABLE STATUS WHERE Name = \''.$name.'\'')
            ->getQuery()
            ->getOne();

        $fields = $driverInterface
            ->createQuery('DESCRIBE `'.$name.'`')
            ->getQuery()
            ->getAll();

        foreach ($fields as $field) {
            $field = new FieldParser($field, true);
            $alias = $this->parseName($field->getName());
            $this->fields[$alias] = $field;
            $this->new_fields[$alias] = $field;
            if ('primary' == $field->getKey()) {
                $this->primary = $field->getName();
            }
        }
    }

    /**
     * @param array $fields
     */
    protected function parseNotExistsTable(array $fields)
    {
        $this->new_fields = [];

        foreach ($fields['fields'] as $alias => $field) {
            $isExists = false;
            $flag = false;
            if (array_key_exists($alias, $this->fields) && $this->fields[$alias]->getName()) {
                $isExists = true;
                $flag = true;
            }
            $field = new FieldParser($field, $isExists, $flag);
            $this->new_fields[$alias] = $field;
            if ('primary' == $field->getKey()) {
                $this->primary = $field->getName();
            }
        }
    }

    /**
     * @return boolean
     */
    public function isExists()
    {
        return $this->exists;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param array $fields
     * @return $this
     */
    public function setNewFields(array $fields)
    {
        $this->parseNotExistsTable($fields);

        return $this;
    }

    /**
     * @return FieldParser[]
     */
    public function getNewFields()
    {
        return $this->new_fields;
    }

    /**
     * @param $name
     * @return FieldParser|null
     */
    public function getNewField($name)
    {
        return array_key_exists($name, $this->new_fields) ? $this->new_fields[$name] : null;
    }

    /**
     * @return FieldParser[]
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param $name
     * @return FieldParser|null
     */
    public function getField($name)
    {
        if (array_key_exists($name, $this->fields)) {
            return $this->fields[$name];
        }

        return (function () use ($name) {
            foreach ($this->getFields() as $field) {
                if ($field->getName() == $name) {
                    return $field;
                }
            }

            return null;
        })();
    }

    /**
     * @return string
     */
    public function getEngine()
    {
        return isset($this->index['Engine']) ? $this->index['Engine'] : 'INNODB';
    }

    /**
     * @return string
     */
    public function getCharset()
    {
        return isset($this->info['Collation']) ? $this->info['Collation'] : 'utf8';
    }

    /**
     * @return string|int
     */
    public function getAutoIncrement()
    {
        return isset($this->info['Auto_increment']) ? $this->info['Auto_increment'] : 0;
    }

    /**
     * @return string|int
     */
    public function getSize()
    {
        return isset($this->info['Rows']) ? $this->info['Rows'] : 0;
    }


    /**
     * @return string
     */
    public function getStructure()
    {
        return $this->create_sql;
    }

    /**
     * Get table primary key name.
     *
     * @return string
     */
    public function getPrimary()
    {
        return $this->primary;
    }

    /**
     * @return array
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * Make create table or alter table sql string.
     *
     * @return string
     */
    public function makeSQL()
    {
        return $this->isExists() ? $this->makeAlter() : $this->makeCreate();
    }

    /**
     * Make alter table sql.
     *
     * @return string
     */
    public function makeAlter()
    {
        $alters = [];
        $index = [];
        $drop = [];

        foreach ($this->getNewFields() as $alias => $field) {
            $oldField = $this->getField($field->getName());
            if (!$field->equals($oldField)) {
                $alters[] = $field->makeAlterSQL($this);
            }

            if (null !== $oldField) {
                if (!empty($oldField->getKey()) && !$field->isPrimary() && null == $field->getKey() && null != $oldField->getKey()) {
                    $drop[] = $oldField->makeDropIndexSQL($this);
                }
            }

            if (null !== $oldField && (!$oldField->isPrimary() && null != $field->getKey() && $field->getKey() != $oldField->getKey())) {
                $index[] = $field->makeAddIndexSQL($this);
            }
        }

        $sql = array_merge($alters, $drop);
        $sql = array_merge($sql, $index);

        return implode(PHP_EOL, $sql);
    }

    /**
     * Make create table sql.
     *
     * @return string
     */
    public function makeCreate()
    {
        $create = [];
        foreach ($this->getNewFields() as $alias => $field) {
            $create[] = $field->makeCreateSQL();
        }
        $create = implode(','.PHP_EOL, $create);

        return
            "CREATE TABLE `{$this->getName()}` (".PHP_EOL.
            $create.
            PHP_EOL.") ENGINE {$this->getEngine()} CHARSET {$this->getCharset()}";
    }
}