<?php
/**
 * Created by PhpStorm.
 * User: unm
 * Date: 23/07/17
 * Time: 18:45
 */

namespace UnmBtg\Presenters;


use UnmBtg\Entities\EntityInterface;

interface PresenterInterface
{
    /**
     * Indicate if it was an exception or it's an valid result.
     * @return boolean
     */
    public function isException();

    /**
     * Basic rendering of the entity or exception to be presented.
     * @param mixed[] $params Array Modifiers of behavior.
     * @return array Array with the corrects parameters that must be displayed.
     */
    public function render($params = null);

    /**
     * Returns all the relations asked for the given Entity.
     * @param array $params Array all related components.
     * @return PresenterInterface[] Array with the correct relations.
     */
    public function relations($params = []);

    /**
     * Type identifier of the Entity.
     * @return string
     */
    public function getType();

    /**
     * @return mixed Identifier of the current Entity
     */
    public function getIdentifier();
}