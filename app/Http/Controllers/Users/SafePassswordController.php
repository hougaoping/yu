<?php

namespace App\Http\Controllers\Users;

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
            if (empty($request->safe_password)) {
                $this->error('请填写新的登录密码');
            }
            if($request->safe_password != $request->safe_password_repeat) {
                $this->error('两次密码不相同');
            }

            
        }
    }
}