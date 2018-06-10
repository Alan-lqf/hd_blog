<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class CategoryController extends CommonController
{
    public function index()
    {
        $category = (new Category)->tree();
        return view('admin.category.index')->with('data', $category);
    }


    public function changeOrder()
    {
        $input = Input::all();
        $cate = Category::find($input['id']);
        $cate->order = $input['order'];
        $re = $cate->update();
        if($re){
            $data = [
                'status' => 0,
                'msg' => '分类排序更新成功！'
            ];
        }else{
            $data = [
                'status' => 1,
                'msg' => '分类排序更新失败！请稍后重试。'
            ];
        }
        return $data;

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
