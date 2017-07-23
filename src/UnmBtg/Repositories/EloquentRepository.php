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

class EloquentRepository implements RepositoryInterface
{
    protected $entity;

    public function __construct(EntityElloquentInterface $entity)
    {
        $this->entity = $entity;
    }

    public function getKeyName()
    {
        $this->getEntity()->getKeyName();
    }


    /**
     * @var CriteriaInterface[]
     */
    protected $criterias = [];

    /**
     * @return EntityElloquentInterface
     */
    public function getEntity(){
        return clone $this->entity;
    }


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
        return $this;
    }

    public function get()
    {
        return $this->applyCriteria()->get();
    }

    public function first()
    {
        $this->applyCriteria()->first();
    }

    public function create($attributes)
    {
        if ($this->isValid($attributes)) {
            return $this->save($this->getEntity(), $attributes);
        }
    }

    public function update($identifier, $attributes)
    {
        if ($this->isValid($attributes, $identifier)) {
            return $this->save($this->find($identifier), $attributes);
        }
    }

    public function delete($identifier)
    {
        $element = $this->find($identifier);
        $element->delete();
        return $element;
    }

    protected function save(EntityElloquentInterface $entity, $attributes) {
        $keep = $entity->fill($attributes);
        $entity->save();
        return $keep;
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