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

use FastD\Database\Schema\Structure\Rename;
use FastD\Generator\Factory\GetSetter;
use FastD\Generator\Factory\Obj;
use FastD\Generator\Factory\Property;
use FastD\Generator\Generator;

/**
 * 数据模型结构反射
 *
 * Class SchemaReflex
 *
 * @package FastD\Database\Schema
 */
class SchemaReflex
{
    use Rename;

    const REFLEX_ENTITIES = 'Entities';
    const REFLEX_MODELS = 'Models';
    const REFLEX_FIELDS = 'Fields';
    const BASE_NAMESPACE = '\FastD\Database\ORM';

    /**
     * @var Schema[]
     */
    protected $schemas = [];

    /**
     * SchemaReflex constructor.
     *
     * @param Schema[] $schemas
     */
    public function __construct(array $schemas)
    {
        $this->schemas = $schemas;
    }

    /**
     * @return Schema[]
     */
    public function getSchemas()
    {
        return $this->schemas;
    }

    /**
     * @param $dir
     * @param $type
     * @return string
     */
    protected function getReflexDir($dir, $type)
    {
        $dir = implode(DIRECTORY_SEPARATOR, array_map(function ($v) {
            return ucfirst($v);
        }, explode(DIRECTORY_SEPARATOR, $dir)));

        return str_replace('//', '/', ($dir . DIRECTORY_SEPARATOR . $type));
    }

    /**
     * @param $namespace
     * @param $type
     * @return mixed
     */
    protected function getReflexNamespace($namespace, $type)
    {
        $namespace = implode('\\', array_map(function ($v) {
            return ucfirst($v);
        }, explode('\\', $namespace)));

        return str_replace('\\\\', '\\', $namespace . '\\' . $type);
    }

    /**
     * @param $dir
     * @param null $namespace
     * @return array
     */
    public function reflex($dir = __DIR__, $namespace = null)
    {
        return [
            'fields' => $this->reflexFields($dir, $namespace),
            'entities' => $this->reflexEntities($dir, $namespace),
            'models' => $this->reflexModels($dir, $namespace)
        ];
    }

    /**
     * @param $namespace
     * @return array
     */
    protected function getFieldsConstants($namespace)
    {
        $fields = new Property('FIELDS', Property::PROPERTY_CONST);
        $fields->setValue('\\' . $namespace . '::FIELDS');

        $alias = new Property('ALIAS', Property::PROPERTY_CONST);
        $alias->setValue('\\' . $namespace . '::ALIAS');

        $table = new Property('TABLE', Property::PROPERTY_CONST);
        $table->setValue('\\' . $namespace . '::TABLE');

        return [
            'FIELDS'    => $fields,
            'ALIAS'     => $alias,
            'TABLE'     => $table,
        ];
    }

    /**
     * @param $dir
     * @param null $namespace
     * @return array Return file save path and status
     */
    public function reflexEntities($dir = __DIR__, $namespace = null)
    {
        $dir = $this->getReflexDir($dir, self::REFLEX_ENTITIES);

        $files = [];

        foreach ($this->getSchemas() as $schema) {
            $name = ucfirst($this->rename($schema->getTable()->getTableName()));

            $file = $dir . '/' . $name . 'Entity.php';

            $entity = new Generator($name . 'Entity', $this->getReflexNamespace($namespace, self::REFLEX_ENTITIES), Obj::OBJECT_CLASS);

            $entity->setExtends(new Obj('Entity', static::BASE_NAMESPACE));

            $properties = [];
            $methods = [];
            
            foreach ($schema->getFields() as $field) {
                $properties[$field->getAlias()] = new Property($field->getAlias());
                $methods[] = new GetSetter($field->getAlias());
            }

            $entity->setProperties($properties, true);
            $entity->setMethods($methods, true);

            $entity->setProperties($this->getFieldsConstants($this->getReflexNamespace($namespace, self::REFLEX_FIELDS) . '\\' . $name));

            $files[$file] = $entity->save($file);
        }

        return $files;
    }

    /**
     * @param $dir
     * @param null $namespace
     * @return array Return file save path and status
     */
    public function reflexModels($dir = __DIR__, $namespace = null)
    {
        $dir = $this->getReflexDir($dir, self::REFLEX_MODELS);

        $files = [];

        foreach ($this->getSchemas() as $schema) {
            $name = ucfirst($this->rename($schema->getTable()->getTableName()));

            $file = $dir . '/' . $name . 'Model.php';

            $model = new Generator($name . 'Model', $this->getReflexNamespace($namespace, self::REFLEX_MODELS), Obj::OBJECT_CLASS);

            $model->setExtends(new Obj('Model', self::BASE_NAMESPACE));

            $model->setProperties($this->getFieldsConstants($this->getReflexNamespace($namespace, self::REFLEX_FIELDS) . '\\' . $name));

            $files[$file] = $model->save($file);
        }

        return $files;
    }

    /**
     * @param $dir
     * @param null $namespace
     * @return array
     */
    public function reflexFields($dir = __DIR__, $namespace = null)
    {
        $dir = $this->getReflexDir($dir, self::REFLEX_FIELDS);

        $files = [];
        
        foreach ($this->getSchemas() as $schema) {
            $name = ucfirst($this->rename($schema->getTable()->getTableName()));
            $file = $dir . '/' . $name . '.php';

            $fields = [];
            $alias = [];

            foreach ($schema->getTable()->getFields() as $field) {
                $fields[$field->getAlias()] = [
                    'alias'     => $field->getAlias(),
                    'name'      => $field->getName(),
                    'length'    => $field->getLength(),
                    'type'      => $field->getType(),
                    'notnull'   => $field->isNullable(),
                    'unsigned'  => $field->isUnsigned(),
                    'default'   => $field->getDefault(),
                ];

                $alias[$field->getName()] = $field->getAlias();
            }

            $field = new Generator($name, $this->getReflexNamespace($namespace, self::REFLEX_FIELDS), Obj::OBJECT_CLASS);

            $fieldsConst = new Property('FIELDS', Property::PROPERTY_CONST);
            $fieldsConst->setValue($fields);

            $aliasConst = new Property('ALIAS', Property::PROPERTY_CONST);
            $aliasConst->setValue($alias);

            $tableConst = new Property('TABLE', Property::PROPERTY_CONST);
            $tableConst->setValue($schema->getTable()->getFullTableName());

            $field->setProperties([
                $fieldsConst,
                $aliasConst,
                $tableConst
            ], true);

            $files[$file] = $field->save($file);
        }

        return $files;
    }
}