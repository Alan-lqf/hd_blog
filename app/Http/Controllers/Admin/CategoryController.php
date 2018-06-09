<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Category;
use Illuminate\Http\Request;

class CategoryController extends CommonController
{
    public function index()
    {
        $category = (new Category)->tree();
        return view('admin.category.index')->with('data', $category);
    }



    public function create()
    {
        
    }

    public function store()
    {
        
    }

    public function show()
    {
        
    }

    public function update()
    {
        
    }

    public function destroy()
    {
        
    }

    public function edit()
    {
        
    }
}
