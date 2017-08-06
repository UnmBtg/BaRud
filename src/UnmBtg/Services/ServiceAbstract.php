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

abstract class ServiceAbstract implements ServiceInterface
{

    protected $repo;

    /**
     * @return RepositoryInterface
     */
    public abstract function getRepository();

    public function __construct()
    {
        $this->repo = $this->getRepository();
    }

    public function getAll() {
        return $this->refreshRepo()->get();
    }

    public function refreshRepo() {
        $this->repo = $this->getRepository();
        return $this->repo;
    }

    public function update($identifier, $attributes) {
        return $this->repo->update($identifier, $attributes);
    }

    public function save($attributes) {

        $identifier = $this->repo->getKeyName();
        if (isset($attributes[$identifier])) {
            $this->repo->update($attributes[$identifier], $attributes);
        }

        return $this->repo->create($attributes);
    }

    public function search($filters)
    {
        $criteria = new RequestCriteria($filters);
        return $this->repo->addCriteria($criteria)->get();
    }

    public function delete($identifier) {
        return $this->repo->delete($identifier);
    }

    public function find($identifier)
    {
        return $this->repo->find($identifier);
    }

    public function getLastErrors() {
        return $this->repo->getValidationErrors();
    }
}