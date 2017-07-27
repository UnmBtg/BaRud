<?php
/**
 * Created by PhpStorm.
 * User: unm
 * Date: 23/07/17
 * Time: 18:48
 */

namespace UnmBtg\Presenters;



use UnmBtg\Entities\EntityInterface;
use UnmBtg\Exceptions\HttpExceptionInterface;

class DefaultPresenter implements PresenterInterface
{
    /**
     * @var EntityInterface|\Exception
     */
    protected $entity;

    protected $relation = [];

    public function __construct($entity)
    {
        $this->entity = $entity;
    }

    public function isException()
    {
        return $this->entity instanceof \Exception;
    }

    public function render($params = null)
    {
        if ($this->isException()) {
            return $this->renderException();
        }

        return $this->entity->toArray();
    }

    protected function renderException() {

        /**
         * @var $exception \Exception
         */
        $exception = $this->entity;

        $data =  [
            'message' => $exception->getMessage(),
            'code'    => $exception->getCode(),
            'trace'   => $exception->getTraceAsString(),
            'file'    => $exception->getFile(),
            'line'    => $exception->getLine()
        ];

        if ($exception instanceof HttpExceptionInterface && $exception->getEnv() == "production") {
            unset($data['trace']);
            unset($data['line']);
            unset($data['file']);
        }

        return $data;
    }

    public function relations($params = [])
    {
        $relations = [];

        if (is_string($params)) {
            $params = explode(",", $params);
        }

        foreach ($params as $relation) {
            $relations[] = $this->getRelation($relation);
        }

        return $relations;
    }

    public function getRelation($relation) {

        if (isset($this->entity, $relation)) {
            return $this->entity->{$relation};
        }

        return null;
    }


    public function getType()
    {
        return $this->entity->getName();
    }

    public function getIdentifier()
    {
        return $this->entity->getIdentifier();
    }

}