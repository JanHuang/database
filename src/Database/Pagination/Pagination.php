<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 16/4/19
 * Time: 下午11:34
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Database\Pagination;

use FastD\Database\ORM\Model;

/**
 * Class Pagination
 * @package FastD\Database\Pagination
 */
class Pagination extends \FastD\Pagination\Pagination
{
    /**
     * @var null|array
     */
    protected $result;

    /**
     * Pagination constructor.
     * @param Model $model
     * @param int $currentPage
     * @param int $showList
     * @param int $showPage
     */
    public function __construct(Model $model, $currentPage = 1, $showList = 25, $showPage = 5)
    {
        parent::__construct($model->count(), $currentPage, $showList, $showPage);

        $offset = ($currentPage - 1) * $showList;

        $sql = 'SELECT * FROM `' . $model->getTable() . '` INNER JOIN (SELECT id FROM `' . $model->getTable() . '` LIMIT ' . $offset . ',' . $showList . ') t2 USING (id);';

        $this->result = $model->createQuery($sql)->execute()->getAll();
    }

    /**
     * @return array|null
     */
    public function getResult()
    {
        return $this->result;
    }
}