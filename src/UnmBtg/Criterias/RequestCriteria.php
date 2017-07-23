<?php
/**
 * Created by PhpStorm.
 * User: unm
 * Date: 22/07/17
 * Time: 17:47
 */

namespace UnmBtg\Criterias;


use UnmBtg\Repositories\QueryBuilderInterface;
use UnmBtg\Repositories\RepositoryInterface;

class RequestCriteria implements CriteriaInterface
{
    protected $filters;

    /**
     * @var QueryBuilderInterface
     */
    protected $builder;

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    public function apply(QueryBuilderInterface $repository)
    {
        $this->repository = $repository;
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

        return $this->builder->where($name, $arguments[1]);
    }

}