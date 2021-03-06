<?php
/**
 * Created by PhpStorm.
 * User: unm
 * Date: 23/07/17
 * Time: 01:22
 */

namespace UnmBtg\EloquentWarper;


use UnmBtg\Entities\EntityElloquentInterface;
use UnmBtg\Presenters\DefaultPresenter;
use UnmBtg\Presenters\Presentable;
use UnmBtg\Presenters\PresenterInterface;
use UnmBtg\Repositories\EloquentRepository;

abstract class Model extends \Illuminate\Database\Eloquent\Model implements EntityElloquentInterface, Presentable
{
    public function getPresenter()
    {
        return new DefaultPresenter($this);
    }

    public function newEloquentBuilder($query)
    {
        return new QueryBuilder($query);
    }

    public function getQueryBuilder()
    {
        return $this->newQuery();
    }

    public function getName()
    {
        return $this->getTable();
    }

    public function getIdentifier()
    {
        return $this->getKey();
    }


    public function getRepository()
    {
        return new EloquentRepository($this);
    }

    public abstract function getValidator();

    public function where($column, $operator = null, $value = null, $boolean = 'and')
    {
        return parent::where($column, $operator, $value, $boolean); // TODO: Change the autogenerated stub
    }

    public function find($id, $columns = ['*'])
    {
        return parent::find($id, $columns); // TODO: Change the autogenerated stub
    }

    public function get()
    {
        return $this->get();
    }

    public function first($columns = ['*'])
    {
        return parent::first($columns); // TODO: Change the autogenerated stub
    }

    public function order($column, $direction)
    {
        return $this->orderBy($column, $direction);
    }



}