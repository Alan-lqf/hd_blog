<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

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
        $data = Category::where('pid', 0)->get();
        return view('admin.category.add', compact('data'));
    }

    public function store()
    {
        $input = Input::except('_token');
        $rules = [
            'name' => 'required',
        ];
        $message = [
            'name.required' => '分类名称不能为空！',
        ];
        $validator = Validator::make($input, $rules, $message);
        if($validator->passes()){
            $re = Category::create($input);
            if ($re){
                return redirect('admin/category');
            }else{
                return back()->with('errors', '数据添加失败，请稍后重试！');
            }
        }else{
            return back()->withErrors($validator);
        }
    }

    public function show()
    {
        
    }

    public function edit($id)
    {
        $field = Category::find($id);
        $data = Category::where('pid', 0)->get();
        return view('admin.category.edit', compact('field', 'data'));
    }

    public function update($id)
    {
        $input = Input::except('_token', '_method');
        $re = Category::where('id', $id)->update($input);
        if ($re){
            return redirect('admin/category');
        }else{
            return back()->with('errors', '分类信息更新失败，请稍后重试！');
        }
    }

    public function destroy($id)
    {
        $re = Category::where('id', $id)->delete();
        Category::where('pid', $id)->update(['pid' => 0]);
        if ($re){
            $data = [
                'status' => 0,
                'msg' => '分类删除成功！'
            ];
        }else{
            $data = [
                'status' => 1,
                'msg' => '分类删除失败！'
            ];
        }
        return $data;

    }

}
