<?php
/**
 * Created by PhpStorm.
 * User: marco
 * Date: 27/07/2017
 * Time: 02:07
 */

namespace UnmBtg\Services;


interface ServiceInterface
{
    public function update($identifier, $attributes);

    public function save($attributes);

    public function search($filters);

    public function delete($identifier);

    public function find($identifier);

    public function getLastErrors();
}