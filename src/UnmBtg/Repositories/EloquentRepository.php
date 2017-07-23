<?php
/**
 * Created by PhpStorm.
 * User: unm
 * Date: 22/07/17
 * Time: 18:29
 */

namespace UnmBtg\Repositories;


use UnmBtg\Criterias\CriteriaInterface;
use UnmBtg\Entities\EntityElloquentInterface;
use UnmBtg\Validators\ValidatorStage;

abstract class EloquentRepository implements RepositoryInterface
{

    /**
     * @var CriteriaInterface[]
     */
    protected $criterias = [];

    /**
     * @return EntityElloquentInterface
     */
    public abstract function getEntity();


    public function where($parameter, $filter = "=", $value = null)
    {
        return $this->getEntity()->where($parameter, $filter, $value);
    }

    /**
     * @param $identifier
     * @return EntityElloquentInterface
     */
    public function find($identifier)
    {
        return $this->getEntity()->find($identifier);
    }

    public function addCriteria(CriteriaInterface $criteria)
    {
        $this->criterias[] = $criteria;
    }

    public function get()
    {
        $this->applyCriteria()->get();
    }

    public function first()
    {
        $this->applyCriteria()->first();
    }

    public function create($attributes)
    {
        if ($this->isValid($attributes)) {
            $this->getEntity()->fill($attributes)->save();
        }
    }

    public function update($identifier, $attributes)
    {
        if ($this->isValid($attributes, $identifier)) {
            $this->find($identifier)->update($identifier, $attributes);
        }
    }

    public function delete($identifier)
    {
        $this->delete($identifier);
    }

    public function isValid($attributes, $identifier = null)
    {
        $stage = is_null($identifier) ? ValidatorStage::CREATE : ValidatorStage::UPDATE;
        return $this->getEntity()->getValidator()->validate($attributes,$stage);
    }

    protected function applyCriteria() {
        $builder = $this->getEntity()->getQueryBuilder();
        foreach ($this->criterias as $criteria) {
            $builder = $criteria->apply($builder);
        }

        return $builder;
    }

}