<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Category;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class CategoryController extends CommonController
{
    //get.admin/category  全部分类列表
    public function index()
    {
//        $categorys = Category::tree();
        $categorys = (new Category)->tree();
        return view('admin.category.index')->with('data',$categorys);
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
                'msg' => '分类排序更新成功！',
            ];
        }else{
            $data = [
                'status' => 1,
                'msg' => '分类排序更新失败，请稍后重试！',
            ];
        }
        return $data;
    }

    //get.admin/category/create   添加分类
    public function create()
    {
        $data = Category::where('pid',0)->get();
        return view('admin/category/add',compact('data'));
    }

    //post.admin/category  添加分类提交
    public function store()
    {
        $input = Input::except('_token');
//        dd($input);
        $rules = [
            'name'=>'required',
        ];

        $message = [
            'name.required'=>'分类名称不能为空！',
        ];

        $validator = Validator::make($input,$rules,$message);

        if($validator->passes()){
            $re = Category::create($input);
            if($re){
                return redirect('admin/category');
            }else{
                return back()->with('errors','数据填充失败，请稍后重试！');
            }
        }else{
            return back()->withErrors($validator);
        }
    }

    //get.admin/category/{category}/edit  编辑分类
    public function edit($id)
    {
        $field = Category::find($id);
        $data = Category::where('pid',0)->get();
        return view('admin.category.edit',compact('field','data'));
    }

    //put.admin/category/{category}    更新分类
    public function update($id)
    {
        $input = Input::except('_token','_method');
        $re = Category::where('id',$id)->update($input);
        if($re){
            return redirect('admin/category');
        }else{
            return back()->with('errors','分类信息更新失败，请稍后重试！');
        }
    }

    //get.admin/category/{category}  显示单个分类信息
    public function show()
    {

    }

    //delete.admin/category/{category}   删除单个分类
    public function destroy($id)
    {
        $re = Category::where('id',$id)->delete();
        Category::where('pid',$id)->update(['pid'=>0]);
        if($re){
            $data = [
                'status' => 0,
                'msg' => '分类删除成功！',
            ];
        }else{
            $data = [
                'status' => 1,
                'msg' => '分类删除失败，请稍后重试！',
            ];
        }
        return $data;
    }


}
