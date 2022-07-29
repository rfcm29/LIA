<?php

namespace App\Http\Controllers;

use App\Models\KitCategory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        session()->put('categories', KitCategory::all());
        return view('layouts.menu', ['categories' => KitCategory::all()]);
    }

    public function adminIndex(){
        return view('layouts.admin-home');
    }
}
