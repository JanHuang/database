<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/8/1
 * Time: 下午2:43
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Database\Repository;

/**
 * Interface StdRepositoryInterface
 *
 * @package FastD\Database\Repository
 */
interface RepositoryInterface
{
    /**
     * @return array
     */
    public function getFields();

    /**
     * @param array      $data
     * @param array|null $fields
     * @return array
     */
    public function buildTableFieldsData(array $data, array $fields = null);

    /**
     * @param array      $data
     * @param array|null $fields
     * @return array
     */
    public function parseTableFieldsData(array $data, array $fields = null);
}