<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Auth;
use Validator;
use App\Models\User;

class IndexController extends BaseController
{
    public function __construct() {

    }

    // 管理员登录页面
	public function index(Request $request) {
        
        if (session()->has('is_admin') && session()->get('is_admin') == 1) {
            return redirect()->route('admin.dashboard');
        }

		if($request->isMethod('get')) {
			return view('admin.index');
		} else {
            $validator = Validator::make($request->all(), [
                'email'    => 'required',
                'password'    => 'required',
                // 'captcha'     => 'required|captcha',
            ], [
                'captcha.required' => '验证码不能为空',
                'captcha.captcha'  => '验证不正确',
            ]);
            
            if ($validator->fails()) {
                $this->error($validator->errors()->first());
            }

            $user = User::where('email', $request->email)->where('is_admin', 1)->first();
            if (!$user) {
                $this->error('帐号不存在');
            }

            if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'is_admin' => 1])) {
                request()->session()->regenerate();
                session()->put('is_admin', intval(true));
                
                $user->recordLastLoginLog();
                $user->recordLoginLog($request->email, true);
                $this->success('登录成功', route('admin.dashboard'));
            } else {
                $user->recordLoginLog($request->email, false);
                $this->error('帐号或密码验证失败');
            }

		}
	}
}
