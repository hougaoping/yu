<?php

namespace App\Http\Controllers\Users;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserEmail;
use App\Models\PasswordReset;
use Mail;
use Carbon\Carbon;
use App\Jobs\SendEmail;
use Validator;

class ForgotController extends BaseController
{
    public function reset(Request $request) {
        $PasswordReset = PasswordReset::where('email', $request->email)->where('token', $request->token)->first();
        if (!$PasswordReset) {
            abort('404');
        }

        if($request->isMethod('get')) {
            return view('users.forgot.reset', ['token' => $request->token, 'email' => $request->email]);
        }else {
          
            $validator = Validator::make($request->all(), [
                'password' => 'required|confirmed|min:6'
            ], [
                'password.required'     => '登录密码不能为空',
                'password.confirmed'    => '两次密码必须一致',
            ]);
            
            if ($validator->fails()) {
                $this->error($validator->errors()->first());
            }

            User::where('id', $PasswordReset->user_id)->update(['password' => bcrypt($request->password)]);
            PasswordReset::where('email', $request->email)->delete();
            $this->success('密码修改成功', '/');
        }
    }

	public function index(Request $request) {
		
        if($request->isMethod('get')) {
            return view('users.forgot.index');
        }else {

            $validator = Validator::make($request->all(), [
                'email' => 'required|email|max:255',
            ], [
                'email.required'     => '电子邮箱不能为空',
            ]);
            
            if ($validator->fails()) {
                $this->error($validator->errors()->first());
            }

            $user = UserEmail::where('email', $request->email)->first();
            if ($user) {
                PasswordReset::where('email',  $request->email)->delete();
                $passwordReset = PasswordReset::create(['email' => $request->email, 'token' => str_random(30), 'user_id' => $user->id, 'created_at'=> Carbon::now()]);
                $view    = 'emails.forgot';
                $data    = compact('passwordReset');
                $to      = $user->email;
                $subject = sprintf("找回密码 %s", setting('name'));
                dispatch(new SendEmail(['view' => $view, 'data' => $data, 'to' => $to, 'subject' => $subject]));
                $this->success(sprintf('已发送 %s', $user->email));
            }else {
                $this->error('未找到电子邮件');
            }
        }
    }    
}