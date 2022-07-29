<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        return view('admin.users.index', ['users' => User::all()]);
    }

    public function show($id){
        return view('admin.users.show', ['user' => User::find($id), 'permissions' => Permission::all()]);
    }
}
