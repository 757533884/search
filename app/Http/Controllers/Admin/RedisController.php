<?php
/**
 * Created by PhpStorm.
 * User: hongyang
 * Date: 2019-09-05
 * Time: 16:39
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;

class RedisController extends Controller
{
    public  function demo1(){
        Redis::set('name', 'guwenjie123');
        $values = Redis::get('name');
        dd($values);
    }
}