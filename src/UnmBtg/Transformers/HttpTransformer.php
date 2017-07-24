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

    protected $relateds = [];

    protected $data = [];

    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * @param Presentable[] $presentables
     * @return array
     */
    public function render($presentables)
    {
        $this->data = [];
        $presentables = $this->normalize($presentables);

        foreach ($presentables as $presentable) {
            $this->data[$presentable->getPresenter()->getIdentifier()] = $this->baseRender($presentable);
            $this->data[$presentable->getPresenter()->getIdentifier()]['relations'] = [];
        }

        $related = $this->getRelations($presentables);

        return [
            'success' => !$this->hasError,
            'data' => array_values($this->data),
            'relationships' => array_values($related)
        ];
    }

    protected function getRelations($presentables) {

        if (!isset($this->request['with'])) {
            return [];
        }

        $related = [];

        foreach ($presentables as $presentable) {
            $relation = $this->cleanRelations($this->getRelation($presentable, $this->request['with']));
            $this->append($presentable, $relation);
            $related = array_merge($related, $relation);
        }

        return $related;
    }

    /**
     * @param Presentable $presentable
     * @param array $relations
     * @return array
     */
    protected function append(Presentable $presentable, $relations = []) {
        if (empty($relations)) {
            return $relations;
        }
        foreach ($relations as $relation) {
            unset($relation['attributes']);
            $this->data[$presentable->getPresenter()->getIdentifier()]['relations'][] = $relation;
        }
    }

    /**
     * @param $related Presentable[]
     * @return array
     */
    protected function cleanRelations($related) {
        $clean = [];
        foreach ($related as $value) {
            if ($value instanceof \Traversable) {
                return $this->cleanRelations($value);
            }
            $presenter = $value->getPresenter();
            $id = "{$presenter->getType()}.{$presenter->getIdentifier()}";


            $clean[$id] = $this->baseRender($value);
        }

        return $clean;
    }


    protected function getRelation(Presentable $presentable, $relations) {
        return $presentable->getPresenter()->relations($relations);
    }

    /**
     * @param Presentable[] $presentable
     * @return Presentable[]
     */
    protected function normalize($presentable) {
        if ($presentable instanceof \Traversable) {
            return $presentable;
        }

        return [$presentable];
    }

    protected function baseRender(Presentable $presentable) {
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