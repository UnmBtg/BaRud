<?php
/**
 * Created by PhpStorm.
 * User: unm
 * Date: 23/07/17
 * Time: 18:30
 */

namespace UnmBtg\Transformers;


use UnmBtg\Presenters\Presentable;

class HttpTransformer implements TransformerInterface
{
    protected $request;

    protected $hasError = false;
    public function __construct($request)
    {
        $this->request = $request;
    }

    public function render($presentables)
    {
        $data = [];
        $presentables = $this->normalize($presentables);

        foreach ($presentables as $presentable) {
            $data[] = $this->baseRender($presentable);
        }

        $related = $this->getRelations($presentables);

        return [
            'data' => $data,
            'success' => !$this->hasError,
            'relationships' => $related
        ];
    }

    protected function getRelations($presentables) {

        if (!isset($this->request['with'])) {
            return [];
        }

        $related = [];
        foreach ($presentables as $presentable) {
            $related[] = $this->getRelation($presentable, $this->request['with']);
        }
    }

    /**
     * @param $related Presentable[]
     * @return array
     */
    protected function cleanRelations($related) {
        $clean = [];

        foreach ($related as $value) {
            $presenter = $value->getPresenter();
            $clean[$presenter->getType()][$presenter->getIdentifier()] = $this->baseRender($value);
        }

        return $clean;
    }


    protected function getRelation(Presentable $presentable, $relations) {
        return $presentable->getPresenter()->relations($relations);
    }

    protected function normalize($presentable) {
        if ($presentable instanceof \Traversable) {
            return $presentable;
        }

        return [$presentable];
    }

    public function baseRender(Presentable $presentable) {
        $presenter = $presentable->getPresenter();

        if ($presenter->isException()) {
            $this->hasError = true;
            return $presenter->render($this);
        }

        return [
            'id' => $presenter->getIdentifier(),
            'type' => $presenter->getType(),
            'attributes' => $presenter->render($this)
        ];
    }

}