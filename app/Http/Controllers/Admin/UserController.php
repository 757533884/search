<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
        return view('admin/user/index');
    }

    public function userInfo()
    {
        return view('admin/user/userInfo');
    }
}
