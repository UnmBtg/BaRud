<?php
/**
 * Created by PhpStorm.
 * User: unm
 * Date: 23/07/17
 * Time: 18:30
 */

namespace UnmBtg\Transformers;



interface TransformerInterface
{
    public function render($presentable);
}