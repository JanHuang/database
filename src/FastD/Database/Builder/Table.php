<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 16/2/25
 * Time: 下午5:32
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Database\Builder;

/**
 * Class Table
 *
 * @package FastD\Database\Builder
 */
class Table implements BuilderInterface
{
    const TABLE_CREATE = 1;
    const TABLE_CHANGE = 2;
    const TABLE_ADD = 3;
    const TABLE_DROP = 4;

    /**
     * @var string
     */
    protected $table;

    /**
     * @var Field[]
     */
    protected $fields = [];

    /**
     * @var Field[]
     */
    protected $new_fields = [];

    /**
     * @var Key[]
     */
    protected $keys = [];

    /**
     * @var string
     */
    protected $charset = 'utf8';

    /**
     * @var string
     */
    protected $engine = 'InnoDB';

    /**
     * @var string
     */
    protected $suffix;

    /**
     * @var string
     */
    protected $prefix;

    /**
     * Table constructor.
     * @param $table
     * @param Field[] $fields
     */
    public function __construct($table, $fields = [])
    {
        $this->table = $table;

        foreach ($fields as $field) {
            $this->fields[$field->getName()] = $field;
        }
    }

    /**
     * @return Field[]
     */
    public function getNewFields()
    {
        return $this->new_fields;
    }

    /**
     * @param Field[] $new_fields
     * @return $this
     */
    public function setNewFields($new_fields)
    {
        $this->new_fields = $new_fields;


        return $this;
    }

    /**
     * @param string $name
     * @param Field $field
     * @return $this
     */
    public function addField($name, Field $field)
    {
        $this->new_fields[$name] = $field;

        return $this;
    }

    /**
     * @return string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * @param string $prefix
     * @return $this
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * @return Key[]
     */
    public function getKeys()
    {
        return $this->keys;
    }

    /**
     * @param Key[] $keys
     * @return $this
     */
    public function setKeys($keys)
    {
        $this->keys = $keys;

        return $this;
    }

    /**
     * @param Key $key
     * @return $this
     */
    public function addKey(Key $key)
    {
        $this->keys[] = $key;

        return $this;
    }

    /**
     * @return string
     */
    public function getSuffix()
    {
        return $this->suffix;
    }

    /**
     * @param string $suffix
     * @return $this
     */
    public function setSuffix($suffix)
    {
        $this->suffix = $suffix;

        return $this;
    }

    /**
     * @return string
     */
    public function getEngine()
    {
        return $this->engine;
    }

    /**
     * @param string $engine
     * @return $this
     */
    public function setEngine($engine)
    {
        $this->engine = $engine;

        return $this;
    }

    /**
     * @return string
     */
    public function getCharset()
    {
        return $this->charset;
    }

    /**
     * @param string $charset
     * @return $this
     */
    public function setCharset($charset)
    {
        $this->charset = $charset;

        return $this;
    }

    /**
     * @return Field[]
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param Field[] $fields
     * @return $this
     */
    public function setFields($fields)
    {
        $this->fields = $fields;

        return $this;
    }

    /**
     * @return string
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @param string $table
     * @return $this
     */
    public function setTable($table)
    {
        $this->table = $table;

        return $this;
    }

    /**
     * @param $flag
     * @return string
     */
    protected function getFieldsToSql($flag)
    {
        $fields = [];
        $keys = [];

        $concat = ', ';

        if (in_array($flag, [Field::FIELD_ADD, Field::FIELD_CHANGE])) {
            $concat = ';';
        }

        foreach ($this->fields as $name => $field) {
            if (isset($this->new_fields[$name])) {
                $field->changeTo($this->new_fields[$name]);
            }

            $sql = $field->toSql($flag);

            if (null !== ($key = $field->getKey())) {
                if (Field::FIELD_CREATE === $flag) {
                    $keys[] = $key->toSql($flag);
                } else if (in_array($flag, [Field::FIELD_ADD, Field::FIELD_CHANGE])) {
                    $keys[] = "ALTER TABLE `{$this->getTable()}` " . $key->toSql($flag);
                }
            }

            if (in_array($flag, [Field::FIELD_ADD, Field::FIELD_CHANGE])) {
                $sql = "ALTER TABLE `{$this->getTable()}` " . $sql;
            }

            $fields[] = trim($sql);
        }

        return implode($concat . PHP_EOL, array_merge($fields, $keys));
    }

    /**
     * @param int $flag
     * @return string
     */
    public function toSql($flag = self::TABLE_CREATE)
    {
        switch ($flag) {
            case self::TABLE_CREATE:
                return "CREATE TABLE `{$this->getTable()}` (" . PHP_EOL . "{$this->getFieldsToSql(Field::FIELD_CREATE)}" . PHP_EOL . ") ENGINE={$this->getEngine()} CHARSET={$this->getCharset()};";
            case self::TABLE_CHANGE:
                return "{$this->getFieldsToSql(Field::FIELD_CHANGE)};";
            case self::TABLE_ADD:
                return "{$this->getFieldsToSql(Field::FIELD_ADD)};";
            case self::TABLE_DROP:
                return "DROP TABLE `{$this->getTable()}`;";
        }

        throw new \InvalidArgumentException(sprintf('Operation ["%s"] is undefined.', $flag));
    }

    /**
     * @param null $flag
     * @return string
     */
    public function toYml($flag = null)
    {
        return '';
    }
}