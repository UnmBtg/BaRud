<?php
/**
 * Created by PhpStorm.
 * User: unm
 * Date: 22/07/17
 * Time: 19:06
 */

namespace UnmBtg\Repositories;


use UnmBtg\Criterias\CriteriaInterface;
use UnmBtg\Entities\EntityElloquentInterface;
use UnmBtg\Entities\EntityInterface;

interface RepositoryInterface
{

    /**
     * @param CriteriaInterface $criteria Add a criteria to be used to filter the results.
     * @return self
     */
    public function addCriteria(CriteriaInterface $criteria);


    /**
     * Returns the identifier from the Entity
     * @return string|string[]
     */
    public function getKeyName();


    /**
     * Create an Entity permanently
     * @param $attributes
     * @return EntityElloquentInterface
     */
    public function create($attributes);

    /**
     * Updates an Entity permanently
     * @param $identifier
     * @param $attributes
     * @return EntityElloquentInterface
     */
    public function update($identifier, $attributes);

    /**
     * Deletes an Entity Permanently
     * @param $identifier
     * @return mixed
     */
    public function delete($identifier);

    /**
     * Validates if the given attributes are valid or not.
     * @param $attributes
     * @param null $identifier
     * @return boolean
     */
    public function isValid($attributes, $identifier = null);

    /**
     * Find the Entity that matches the identifier.
     * @param $identifier
     * @return EntityElloquentInterface
     */
    public function find($identifier);

    /**
     * @return EntityInterface[]
     */
    public function get();
}