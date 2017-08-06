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
     * Stores the current entity in the database
     * @return EntityElloquentInterface
     */
    public function save();


    /**
     * Deletes current Entity Permanently
     * @return EntityElloquentInterface
     */
    public function delete();

    /**
     * Find the Entity that matches the identifier.
     * @param $identifier
     * @return EntityElloquentInterface
     */
    public function find($identifier);

    /**
     * @param array $attributes
     * @return EntityElloquentInterface
     */
    public function fill(array $attributes);

}