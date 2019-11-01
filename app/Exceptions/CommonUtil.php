<?php
/**
 * Created by PhpStorm.
 * User: hongyang
 * Date: 2019-09-04
 * Time: 17:38
 */

namespace App\Exceptions;


class CommonUtil
{
    public static function throwException($code, $msg)
    {
        throw new \Exception($msg);
    }
}