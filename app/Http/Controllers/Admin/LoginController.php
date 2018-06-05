<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

require_once 'org/code/Code.class.php';

class LoginController extends CommonController
{
    public function index()
    {
        return view('admin.login');
    }

    public function code()
    {
        $code = new \Code();
        $code->make();
    }


    public function login()
    {
        if($input = Input::all()){
            $code = new \Code();
            $_code = $code->get();
            if($_code != strtoupper($input['code']))
                return back()->with('msg', '验证码错误！');
            $user = User::first();
            if($user->name != $input['username'] || Crypt::decrypt($user->password) != $input['password'])
                return back()->with('msg', '用户名或密码错误！');
            session(['user'=>$user]);
            return redirect('admin/index');
        }
        else{
            return view('admin.login');
        }
    }


    public function quit()
    {
        session(['user'=>null]);
        return redirect('admin/login');
    }
}
