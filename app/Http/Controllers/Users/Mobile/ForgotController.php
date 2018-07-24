<?php

namespace App\Http\Controllers\Users\Mobile;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserEmail;
use App\Models\PasswordReset;
use Mail;
use Carbon\Carbon;
use Validator;

class ForgotController extends BaseController
{
    public function reset(Request $request) {
        
        if($request->isMethod('get')) {
            if (md5($request->mobile.$request->time) != $request->token) {
                abort(404);
            }
            return view('users.mobile.forgot.reset', ['mobile' => $request->mobile]);
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

            if (session()->get('mobile.verify') != $request->verify) {
                $this->error('短信验证码错误');
            }

            User::where('mobile', $request->mobile)->update(['password' => bcrypt($request->password)]);
            $this->success('密码修改成功', '/');
        }
    }

	public function index(Request $request) {
		
        if($request->isMethod('get')) {
            return view('users.mobile.forgot.index');
        }else {

            $validator = Validator::make($request->all(), [
                'mobile' => 'required|mobile|max:11',
            ], [
                'mobile.required'     => '手机号码不能为空',
            ]);
            
            if ($validator->fails()) {
                $this->error($validator->errors()->first());
            }

            $user = User::where('mobile', $request->mobile)->first();
            if ($user) {
                
                $mobile = $_POST['mobile'];
                $code = str_pad(random_int(1, 99999), 5, 0, STR_PAD_LEFT);
                session()->put('mobile.verify', $code);
                $sms  = app('easysms');
                try {
                    $sms->send($mobile, [
                        'content'  =>  view('mobiles.verify', ['code' => $code])->render(),
                    ]);
                } catch (\Overtrue\EasySms\Exceptions\NoGatewayAvailableException $exception) {
                    $message = $exception->getException('yunpian')->getMessage();
                }

                $this->success(sprintf('已发送 %s', $user->mobile), route('forgot.mobile.reset', ['mobile' => $user->mobile, 'time' => time(), 'token'=> md5($user->mobile.time())]));
            }else {
                $this->error('手机号码未找到');
            }
        }
    }    
}