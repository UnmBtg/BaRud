<?php
/**
 * Created by PhpStorm.
 * User: unm
 * Date: 22/07/17
 * Time: 20:40
 */

namespace UnmBtg\Entities;


use UnmBtg\Repositories\RepositoryInterface;
use UnmBtg\Validators\ValidatorInterface;

interface EntityInterface
{

    /**
     * @return RepositoryInterface
     */
    public function getRepository();

    /**
     * @return ValidatorInterface
     */
    public function getValidator();

    /**
     * Fill the entity with attributes passed.
     * @param array $attributes
     * @return self
     */
    public function fill(array $attributes);

    /**
     * @return array returns all values in an array
     */
    public function toArray();

    /**
     * @return string Name to identify this entity
     */
    public function getName();

    /**
     * @return mixed Key to find this Entity
     */
    public function getIdentifier();
}