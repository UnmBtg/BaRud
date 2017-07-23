<?php
/**
 * Created by PhpStorm.
 * User: unm
 * Date: 22/07/17
 * Time: 21:56
 */

namespace UnmBtg\Services;


use UnmBtg\Criterias\RequestCriteria;
use UnmBtg\Repositories\RepositoryInterface;

abstract class ServiceAbstract
{
    /**
     * @return RepositoryInterface
     */
    public abstract function getRepository();

    public function update($identifier, $attributes) {
        return $this->getRepository()->update($identifier, $attributes);
    }

    public function save($attributes) {

        $identifier = $this->getRepository()->getKeyName();
        if (isset($attributes[$identifier])) {
            $this->getRepository()->update($attributes[$identifier], $attributes);
        }

        return $this->getRepository()->create($attributes);
    }

    public function search($filters)
    {
        $criteria = new RequestCriteria($filters);
        return $this->getRepository()->addCriteria($criteria)->get();
    }

    public function delete($identifier) {
        return $this->getRepository()->delete($identifier);
    }
}