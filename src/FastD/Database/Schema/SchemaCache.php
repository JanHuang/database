<?php
/**
 *
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2016
 *
 * @link      https://www.github.com/janhuang
 * @link      http://www.fast-d.cn/
 */

namespace FastD\Database\Schema;

use FastD\Database\Cache\CacheInterface;
use FastD\Database\Schema\Structure\Table;
use FastD\Database\Schema\Structure\Field;

/**
 * Class SchemaCache
 * @package FastD\Database\Schema
 */
class SchemaCache implements CacheInterface
{
    /**
     * @var Field[]
     */
    protected $fieldsCache = [];

    /**
     * @var string
     */
    protected $fieldsCacheFile;

    /**
     * @var Table
     */
    protected $table;

    /**
     * SchemaCache constructor.
     * @param Table $table
     */
    public function __construct(Table $table)
    {
        $this->table = $table;
        
        $fieldsCacheDir = __DIR__ . '/fieldsCache';

        $fieldsCacheFile = $fieldsCacheDir . DIRECTORY_SEPARATOR . '.table.' . $this->table->getFullTableName() . '.cache';

        if (!file_exists($fieldsCacheDir)) {
            mkdir($fieldsCacheDir, 0755, true);
        }

        if (file_exists($fieldsCacheFile)) {
            try {
                $this->fieldsCache = include $fieldsCacheFile;
                $this->fieldsCache = unserialize($this->fieldsCache);
            } catch (\Exception $e) {
                $this->fieldsCache = [];
            }
        }

        $this->fieldsCacheFile = $fieldsCacheFile;

        unset($fieldsCacheDir, $fieldsCacheFile);
    }

    /**
     * @return Table
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @param $name
     * @param Field $field
     * @return $this
     */
    public function setCacheField($name, Field $field)
    {
        $this->fieldsCache[$name] = $field;

        return $this;
    }

    /**
     * @param $name
     */
    public function unsetCacheField($name)
    {
        if (isset($this->fieldsCache[$name])) {
            unset($this->fieldsCache[$name]);
        }
    }

    /**
     * @return int
     */
    public function saveCache()
    {
        return file_put_contents($this->fieldsCacheFile, '<?php return ' . var_export(serialize($this->fieldsCache), true) . ';');
    }

    /**
     * @return array|Field[]
     */
    public function getCache()
    {
        return $this->fieldsCache;
    }

    /**
     *
     */
    public function clearCache()
    {
        if (file_exists($this->fieldsCacheFile)) {
            unlink($this->fieldsCacheFile);
        }
    }
}