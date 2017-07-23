<?php
/**
 * Created by PhpStorm.
 * User: unm
 * Date: 22/07/17
 * Time: 18:37
 */

namespace UnmBtg\Repositories;


use UnmBtg\Entities\EntityElloquentInterface;

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
     * @return EntityElloquentInterface[]
     */
    public function get();

    /**
     * @return EntityElloquentInterface
     */
    public function first();
    
}