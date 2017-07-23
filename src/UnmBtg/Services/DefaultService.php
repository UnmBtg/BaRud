<?php
/**
 * Created by PhpStorm.
 * User: unm
 * Date: 23/07/17
 * Time: 00:21
 */

namespace UnmBtg\Services;


use UnmBtg\Entities\EntityInterface;
use UnmBtg\Repositories\RepositoryInterface;

class DefaultService extends ServiceAbstract
{

    protected $entity;

    public function __construct(EntityInterface $entity)
    {
        $this->entity = $entity;
    }

    public function getRepository()
    {
        return $this->entity->getRepository();
    }


}