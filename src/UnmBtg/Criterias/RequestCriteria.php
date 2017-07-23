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

    public function apply(QueryBuilderInterface $builder)
    {
        $this->builder = $builder;

        if (isset($this->filters['query'])) {
            $builder = $this->applyWhere($this->filters['query'], $builder);
        }

        if (isset($this->filters['order'])) {
            $builder = $builder->order(key($this->filters['order']), current($this->filters['order']));
        }

        return $builder;
    }

    protected function applyWhere($filters = [], QueryBuilderInterface $builder) {
        foreach ($filters as $name => $filter) {

            $builder = $this->$name($builder, $filter);
        }

        return $builder;
    }

    function __call($name, $arguments)
    {
        if (method_exists($this, $name)) {
            return $this->$name($arguments);
        }

        return $arguments[0]->where($name, $arguments[1]);
    }



}