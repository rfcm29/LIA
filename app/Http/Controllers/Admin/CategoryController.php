<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KitCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){
        return view('admin.categories.index', ['categories' => KitCategory::all()]);
    }

    public function create(){
        return view('admin.categories.create');
    }

    public function store(Request $request){
        $request->validate([
            'description' => 'required',
            'image' => 'required'
        ]);

        $imagePath = $request->file('image');
        $imageName = time() . '.' . $imagePath->getClientOriginalExtension();
    
        $path = $request->file('image')->storeAs('images/categories', $imageName, 'public');

        KitCategory::create([
            'description' => $request->description,
            'image' => $path
        ]);

        return redirect()->to('/admin/categories');
    }
}
