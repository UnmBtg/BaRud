<?php
/**
 * Created by PhpStorm.
 * User: unm
 * Date: 22/07/17
 * Time: 20:45
 */

namespace UnmBtg\Validators;


interface ValidatorInterface
{

    public function validate($attributes, $stage);

}