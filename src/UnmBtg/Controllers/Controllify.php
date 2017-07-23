<?php
/**
 * Created by PhpStorm.
 * User: unm
 * Date: 23/07/17
 * Time: 00:05
 */

namespace UnmBtg\Controllers;


use UnmBtg\Services\ServiceAbstract;
use UnmBtg\Transformers\HttpTransformer;

/**
 * Trait Controllify
 * @package UnmBtg\Controllers
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
        if (is_null($this->service) || ! $this->service instanceof ServiceAbstract) {
            throw new \Exception("A Service must be provided and it must be a ". ServiceAbstract::class. ".");
        }

        return $this->service;
    }

    public function indexRequest(array $request) {
        try{
            $items = $this->getService()->search($request);
            return $this->render($request, $items);
        } catch (\Exception $e){
            var_dump($e);exit;
        }

    }

    public function render(array $request, $elements) {
        $transformer = new HttpTransformer($request);
        return $transformer->render($elements);
    }

    public function deleteRequest($identifier) {
        return $this->render([], $this->getService()->delete($identifier));
    }

    public function storeRequest(array $request) {
        return $this->render($request, $this->getService()->save($request));
    }

    public function updateRequest($identifier, array $request){

        return $this->render($request, $this->getService()->update($identifier, $request));
    }

    public function showRequest($identifier) {
        return $this->render([],$this->getService()->find($identifier));
    }

}