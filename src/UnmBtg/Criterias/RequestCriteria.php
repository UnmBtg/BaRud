<?php
/**
 * Created by PhpStorm.
 * User: unm
 * Date: 22/07/17
 * Time: 17:47
 */

namespace UnmBtg\Criterias;


use UnmBtg\Repositories\QueryBuilderInterface;

class RequestCriteria implements CriteriaInterface
{
    protected $filters;

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }


    public function apply(QueryBuilderInterface $repository)
    {
        foreach ($this->filters as $name => $filter) {
            $repository = $this->$name($repository, $filter);
        }

        return $repository;
    }

    public function __call($name, $arguments)
    {
        if (is_callable([$this, $name])){
            return call_user_func([$this, $name], $arguments);
        }
    }


}