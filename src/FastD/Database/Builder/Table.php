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
    const TABLE_DROP = 3;

    /**
     * @var string
     */
    protected $table;

    /**
     * @var Field[]
     */
    protected $fields = [];

    /**
     * @var string
     */
    protected $charset;

    /**
     * @var string
     */
    protected $engine;

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

        $this->fields = $fields;
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

    protected function getFieldsToSql($flag)
    {
        $sql = [];
        foreach ($this->fields as $field) {
            $sql[] = $field->toSql($flag);
        }

        return implode(', ' . PHP_EOL, $sql);
    }

    public function toSql($flag = null)
    {
        switch ($flag) {
            case self::TABLE_CREATE:
                return "CREATE TABLE `{$this->getTable()}`({$this->getFieldsToSql(Field::FIELD_CREATE)}) ENGINE={$this->getEngine()} CHARSET={$this->getCharset()};";
            case self::TABLE_CHANGE:
                return "ALTER TABLE `{$this->getTable()}` {$this->getFieldsToSql(Field::FIELD_CHANGE)};";
            case self::TABLE_DROP:
                return "DROP TABLE `{$this->getTable()}`;";
        }

        throw new \InvalidArgumentException(sprintf('Operation ["%s"] is undefined.', $flag));
    }

    public function toYml($flag = null)
    {
        // TODO: Implement toYml() method.
    }
}