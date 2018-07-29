<?php

namespace App\Http\Controllers\Users;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;

class PassswordController extends BaseController
{
	public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('auth.single');
    }

    public function safePassword(Request $request) {
        if($request->isMethod('get')) {
            return view('users.center.safe_password.index');
        } else {
            if (empty($request->login_password)) {
                $this->error('请填写登录密码');
            }
            if (empty($request->password)) {
                $this->error('请填写新的登录密码');
            }
            if($request->password != $request->password_repeat) {
                $this->error('两次密码不相同');
            }
        }
    }

    public function index(Request $request) {
        if($request->isMethod('get')) {
            return view('users.center.password.index');
        } else {
            if (empty($request->password_old)) {
                $this->error('请填写旧的密码');
            }
            if (empty($request->password)) {
                $this->error('请填写新的登录密码');
            }
            if($request->password != $request->password_repeat) {
                $this->error('两次密码不相同');
            }

            if (\Hash::check($request->password_old, Auth::user()->password))  {
                Auth::user()->password = bcrypt($request->password);
                Auth::user()->save();
            }else {
                $this->error('现用密码不正确');
            }

            $this->success('修改密码成功', '', ['direct'=>false]);
        }
    }
}
