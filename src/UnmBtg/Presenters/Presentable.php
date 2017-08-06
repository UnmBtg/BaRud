<?php
/**
 * Created by PhpStorm.
 * User: unm
 * Date: 23/07/17
 * Time: 18:31
 */

namespace UnmBtg\Presenters;


interface Presentable
{

    /**
     * @return PresenterInterface
     */
    public function getPresenter();

}