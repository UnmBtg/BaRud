<?php
/**
 * Created by PhpStorm.
 * User: unm
 * Date: 22/07/17
 * Time: 17:46
 */

namespace UnmBtg\Criterias;


use UnmBtg\Repositories\QueryBuilderInterface;

interface CriteriaInterface
{
    public function apply(QueryBuilderInterface $repository);
}