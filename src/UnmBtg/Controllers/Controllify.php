<?php
/**
 * Created by PhpStorm.
 * User: unm
 * Date: 23/07/17
 * Time: 00:05
 */

namespace UnmBtg\Controllers;


use UnmBtg\Exceptions\HttpExceptionInterface;
use UnmBtg\Services\ServiceAbstract;
use UnmBtg\Services\ServiceInterface;
use UnmBtg\Transformers\HttpTransformer;

/**
 * Trait Controllify
 * @package UnmBtg\Controllers
 *
 * @property \Throwable $validateException
 */
trait Controllify
{

    /**
     * @var ServiceAbstract
     */
    protected $service;

    /**
     * @return ServiceAbstract
     * @throws \Exception
     */
    public function getService()
    {
        if (is_null($this->service) || ! $this->service instanceof ServiceInterface) {
            throw new \Exception("A Service must be provided and it must be a ". ServiceInterface::class. ".");
        }

        return $this->service;
    }

    public function indexRequest(array $request) {
        $items = $this->getService()->search($request);
        return $this->render($request, $items);
    }

    public function render(array $request, $elements) {
        $transformer = new HttpTransformer($request);
        return $transformer->render($elements);
    }

    public function deleteRequest($identifier) {
        return $this->render([], $this->getService()->delete($identifier));
    }

    public function storeRequest(array $request) {
        $result = $this->getService()->save($request);

        if ( ! $result ) {
            $this->raiseValidationError($this->getService()->getLastErrors());
            return false;
        }

        return $this->render($request, $result);
    }

    public function updateRequest($identifier, array $request){
        $result = $this->getService()->update($identifier, $request);

        if ( ! $result) {
            $this->raiseValidationError($this->getService()->getLastErrors());
            return false;
        }

        return $this->render($request, $result);
    }

    public function showRequest($identifier) {
        return $this->render([],$this->getService()->find($identifier));
    }

    public function raiseValidationError($errros) {

        if (is_null($this->validatorException)) {
            return;
        }

        $validation = new $this->validatorException($errros);

        if ( ! $validation instanceof \Throwable) {
            return null;
        }

        throw $validation;
    }

}