<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
//use Illuminate\Database\Eloquent\Model;

class IndexController extends Controller
{
    //首页展示
    public function index()
    {
        return view('admin/index/index');
        //$data = DB::connection('mysql_U')->select('select * from userinfo_center where telephone=18550282712');
        //return $data;
//        $aa = $this->test($this->welcome(), 'err_code_des');
//        dd($aa);
    }

    //首页右侧部分展示
    public function welcome()
    {
        return view('admin/index/welcome');
    }
    
}
