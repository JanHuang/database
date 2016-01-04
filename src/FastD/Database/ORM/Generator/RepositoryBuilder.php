<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/12/30
 * Time: 下午10:36
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Database\ORM\Generator;

use FastD\Database\ORM\Parser\TableParser;

class RepositoryBuilder extends BuilderAbstract
{
    protected $parse;

    public function __construct(TableParser $parser)
    {
        $this->parse = $parser;
    }

    /**
     * @param        $name
     * @param string $namespace
     * @return array
     */
    protected function buildRepository($name, $namespace = '')
    {
        $entity = $name;
        if (!empty($namespace)) {
            $entity = "{$namespace}\\Entity\\{$name}";
            $namespace = PHP_EOL . 'namespace ' . $namespace . '\\Repository;' . PHP_EOL;
        }

        $maps = [];
        $mapKeys = [];
        foreach ($this->table->getNewFields() as $alias => $field) {
            $mapName = $alias;
            if (empty($mapName)) {
                $mapName = $field->getName();
            }
            $mapKeys[] = "'" . $field->getName() . '\' => ' . "'" . $mapName . "'";
            $maps[] = <<<M
        '{$mapName}' => [
            'type' => '{$field->getType()}',
            'name' => '{$field->getName()}',
            'length'=> {$field->getLength()},
        ],
M;
        }

        $mapKeys = implode(',', $mapKeys);

        $maps = implode(PHP_EOL, $maps);

        $table = $this->table->getName();

        $repository = <<<R
<?php
{$namespace}
use FastD\Database\ORM\Repository;

class {$name}Repository extends Repository
{
    /**
     * @var string
     */
    protected \$table = '{$table}';

    /**
     * @var array
     */
    protected \$structure = [
{$maps}
    ];

    /**
     * @var array
     */
    protected \$fields = [{$mapKeys}];

    /**
     * @var string
     */
    protected \$entity = '{$entity}';
}
R;

        if (!is_dir($repositoryDir = $this->dir . '/Repository')) {
            mkdir($repositoryDir, 0755, true);
        }

        file_put_contents($this->dir . '/Repository/' . $name . 'Repository.php', $repository);

        return [
            'maps' => $maps,
            'keys' => $mapKeys,
        ];
    }

    public function build()
    {
        // TODO: Implement build() method.
    }
}