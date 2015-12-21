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
     * TableParser constructor.
     *
     * @param DriverInterface $driverInterface
     * @param                 $name
     */
    public function __construct(DriverInterface $driverInterface, $name)
    {
        $this->name = $name;

        $this->create_sql = $driverInterface
            ->createQuery('SHOW CREATE TABLE `'.$name.'`')
            ->getQuery()
            ->getOne();

        $this->fields = $driverInterface
            ->createQuery('DESCRIBE `'.$name.'`')
            ->getQuery()
            ->getAll();

        $this->index = $driverInterface
            ->createQuery('SHOW INDEX FROM `'.$name.'`')
            ->getQuery()
            ->getAll();

        $this->info = $driverInterface
            ->createQuery('SHOW TABLE STATUS WHERE Name = \''.$name.'\'')
            ->getQuery()
            ->getOne();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return FieldParser[]
     */
    public function getFields()
    {
        $fields = [];

        foreach ($this->fields as $field) {
            $field = $this->getField($field['Field']);
            $fields[$field->getName()] = $field;
        }

        return $fields;
    }

    /**
     * @param $name
     * @return FieldParser|null
     */
    public function getField($name)
    {
        foreach ($this->fields as $field) {
            if ($name == $field['Field']) {
                return new FieldParser($field);
            }
        }

        return null;
    }

    /**
     * @return string
     */
    public function getEngine()
    {
        return $this->index['Engine'];
    }

    /**
     * @return string
     */
    public function getCharset()
    {
        return $this->info['Collation'];
    }

    /**
     * @return string|int
     */
    public function getAutoIncrement()
    {
        return $this->info['Auto_increment'];
    }

    /**
     * @return string|int
     */
    public function getSize()
    {
        return $this->info['Rows'];
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

    /**
     * @param FieldParser[] $fields
     * @return string
     */
    public function makeAlter(array $fields)
    {
        $existsFields = $this->getFields();
        $alters = [];
        $index = [];
        foreach ($fields as $alias => $field) {
            $isChange = false;
            if (array_key_exists($field->getName(), $existsFields)) {
                $isChange = true;
            }
            $alters[] = $field->makeAlterSQL($this, $isChange);
//            $index[] = $field->makeIndexSQL($this);
        }

        return implode(',', $alters);
    }

    /**
     * @param FieldParser[] $fields
     * @return string
     */
    public function makeCreate(array $fields)
    {
        $create = [];
        foreach ($fields as $alias => $field) {
            $create[] = $field->makeCreateSQL();
        }
        $create = implode(PHP_EOL, $create);

        return
            "CREATE TABLE `{$this->getName()}` (" .
            $create .
            ") ENGINE {$this->getEngine()} CHARSET {$this->getCharset()}";
    }

    public function makeDrop()
    {
        return "DROP TABLE `{$this->getName()}`";
    }

    public function makeDump($user, $pwd, $dir)
    {

    }

    public function compareTableStructure($name, array $fields)
    {

    }
}