<?php
/**
 * Created by PhpStorm.
 * User: marco
 * Date: 26/07/2017
 * Time: 23:35
 */

namespace UnmBtg\Exceptions;


use UnmBtg\Presenters\Presentable;

interface HttpExceptionInterface extends Presentable
{
    /**
     * This is a useless fat code.....
     * @todo make Httptransform be able to se it doesn't need the identifier for this.
     *
     * @return mixed
     */
    public function getIdentifier();

    public function getHttpCode();

    public function getEnv();
}