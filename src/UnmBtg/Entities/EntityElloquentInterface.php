<?php
/**
 * Created by PhpStorm.
 * User: unm
 * Date: 22/07/17
 * Time: 18:19
 */

namespace UnmBtg\Entities;


use UnmBtg\Repositories\QueryBuilderInterface;

interface EntityElloquentInterface extends QueryBuilderInterface , EntityInterface
{
    /**
     * @return QueryBuilderInterface
     */
    public function getQueryBuilder();


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
     * Find the Entity that matches the identifier.
     * @param $identifier
     * @return EntityElloquentInterface
     */
    public function find($identifier);

}