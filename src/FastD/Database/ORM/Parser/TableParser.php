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
    /**
     * @var array|bool
     */
    protected $info;

    /**
     * @var array
     */
    protected $new_fields;

    /**
     * @var array|bool
     */
    protected $fields;

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

        $this->new_fields = [];

        foreach ($fields as $field) {
            $field = new FieldParser($field);
            $this->fields[$field->getName()] = $field;
        }
    }

    protected function parseNotExistsTable(array $fields)
    {
        foreach ($fields['fields'] as $field) {
            $field = new FieldParser($field);
            $this->new_fields[$field->getName()] = $field;
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
        return array_key_exists($name, $this->fields) ? $this->fields[$name] : null;
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
     * @return array
     */
    public function getIndex()
    {
        return $this->index;
    }

    public function makeSQL()
    {
        return $this->isExists() ? $this->makeAlter() : $this->makeCreate();
    }

    /**
     * @return string
     */
    public function makeAlter()
    {
        $alters = [];
        $index = [];
        foreach ($this->getNewFields() as $alias => $field) {
            $isChange = false;
            if (array_key_exists($field->getName(), $this->getFields())) {
                $isChange = true;
            }
            $alters[] = $field->makeAlterSQL($this, $isChange);
//            $index[] = $field->makeIndexSQL($this);
        }

        return implode(PHP_EOL, $alters);
    }

    /**
     * @return string
     */
    public function makeCreate()
    {
        $create = [];
        foreach ($this->getNewFields() as $alias => $field) {
            $create[] = $field->makeCreateSQL();
        }
        $create = implode(PHP_EOL, $create);

        return
            "CREATE TABLE `{$this->getName()}` (" .
            $create .
            ") ENGINE {$this->getEngine()} CHARSET {$this->getCharset()}";
    }

    public function makeDump($user, $pwd, $dir)
    {

    }

    public function compareTableStructure($name, array $fields)
    {

    }
}