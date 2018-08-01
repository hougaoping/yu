<?php

namespace App\Http\Controllers\Users\Center;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;

class SafePassswordController extends BaseController
{
	public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('auth.single');
    }

    public function index(Request $request) {
        if($request->isMethod('get')) {
            return view('users.center.safe_password.index');
        } else {
            if (empty($request->login_password)) {
                $this->error('请填写登录密码');
            }

            if (! \Hash::check($request->login_password, Auth::user()->password))  {
                $this->error('登录密码不正确');
            }

            if (empty($request->safe_password)) {
                $this->error('请填写新的登录密码');
            }

            if($request->safe_password != $request->safe_password_repeat) {
                $this->error('两次密码不相同');
            }

            if($request->login_password == $request->safe_password) {
                $this->error('登录密码与安全密码不能相同');
            }

            if ($request->has('safe_password')) {
                if (! \Hash::check($request->old_safe_password, Auth::user()->safe_password))  {
                    $this->error('现用安全密码不正确');
                }
            }

            Auth::user()->safe_password = bcrypt($request->safe_password);
            Auth::user()->save();
            $this->success('安全密码保存成功');
        }
    }
}