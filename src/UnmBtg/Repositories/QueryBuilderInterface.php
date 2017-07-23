<?php
/**
 * Created by PhpStorm.
 * User: unm
 * Date: 22/07/17
 * Time: 18:37
 */

namespace UnmBtg\Repositories;


use UnmBtg\Entities\EntityInterface;

interface QueryBuilderInterface
{

    /**
     * Add a filter on the query been made
     * @param $parameter parameter to be filtered
     * @param string $comparison if not provided it'll be the value used.
     * @param null $value the value to compare with the parameter
     * @return self
     */
    public function where($parameter, $filter = "=", $value = null);

    /**
     * @return EntityInterface[]
     */
    public function get();

    /**
     * @return EntityInterface
     */
    public function first();

    /**
     * @param $column string Column to be ordered
     * @param $direction string Direction it should be ordered
     * @return self
     */
    public function order($column, $direction);
    
}