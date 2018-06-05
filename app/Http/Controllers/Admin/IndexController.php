<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class IndexController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function info()
    {
        return view('admin.info');
    }

    public function pass()
    {
        if ($input=Input::all()) {
            $rules = [
                'password' => 'required|between:6,20|confirmed',
            ];

            $message = [
                'password.required' => '新密码不能为空！',
                'password.between' => '新密码必须在6到20位之间！',
                'password.confirmed' => '新密码和确认密码不匹配！'
            ];
            $validator = Validator::make($input, $rules, $message);
            if ($validator->passes()){
                $user = User::first();
                if($input['password_o'] == Crypt::decrypt($user->password)){
                    $user->password = Crypt::encrypt($input['password']);
                    $user->update();
                    return back()->with('errors', '密码修改成功！');
                }else{
                    return back()->with('errors', '原密码输入不正确！');
                }

            }else{
                return back()->withErrors($validator);


            }
        }else {
            return view('admin.pass');
        }
    }
}
