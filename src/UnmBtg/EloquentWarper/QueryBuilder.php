<?php
/**
 * Created by PhpStorm.
 * User: unm
 * Date: 23/07/17
 * Time: 00:55
 */

namespace UnmBtg\EloquentWarper;


use Illuminate\Database\Eloquent\Builder;
use UnmBtg\Repositories\QueryBuilderInterface;

class QueryBuilder extends Builder implements QueryBuilderInterface
{

}