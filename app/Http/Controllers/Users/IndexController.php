<?php

namespace App\Http\Controllers\Users;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use App\Models\User;
use App\Models\UserEmail;
use App\Models\UserLoginlog;
use Auth;
use Mail;
use App\Jobs\SendEmail;
use Validator;
use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\RFCValidation;

class IndexController extends BaseController
{

    use ThrottlesLogins;

	public function __construct()
    {
        $this->middleware('auth', [            
            'except' => ['login', 'register', 'confirmEmail']
        ]);
		
		// 已经登录的页面访问则会自动跳转到会员中心
        $this->middleware('guest', [
            'only' => ['login', 'register']
        ]);
    }

    public function username() {
        return 'email';
    }

	public function login(Request $request) {
        
        if($request->isMethod('get')) {
		  return view('users.login');
        } else {

            $this->incrementLoginAttempts($request);
            if($this->hasTooManyLoginAttempts($request)) {
                $seconds = $this->limiter()->availableIn(
                    $this->throttleKey($request)
                );
                $this->error(sprintf('操作太频繁，请 %s 秒后重试', $seconds));
            }

            $validator = Validator::make($request->all(), [
               'email' => 'required|email|max:255',
               'password' => 'required'
            ], [
                'email.required'     => '请输入电子邮箱',
                'password.required'  => '请输入登录密码',
            ]);
            
            if ($validator->fails()) {
                $this->error($validator->errors()->first());
            }

            $user = User::where('email', $request->email)->first();
            
            // 邮箱帐号不存在
            if (!$user) {
                $this->error('邮箱帐号不存在');
            }
            
            // 邮箱帐号未通过验证
            if ($user->userEmail) {
                if (!$user->userEmail->activated) {
                    $this->error('邮箱未验证');
                }
            }

            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $request->session()->regenerate();
                session()->put('username', $request->email);
                session()->put('last_login_time', time());
                
                $user->incrementLoginCount();
                $user->recordLastLoginLog();
                $user->recordLoginLog($request->email, true);
                $this->success('登录成功');
            }else {
                $user->recordLoginLog($request->email, false);
                $this->error('邮箱和密码不匹配');
            }
        }
	} 
	
	public function register(Request $request) {
        if($request->isMethod('get')) {
            return view('users.register');
        }else {

            $validator = Validator::make($request->all(), [
                'email'    => 'required|email|unique:users|max:255',
                'password' => 'required|confirmed|min:6',
                'type'     => 'required'
            ], [
                'email.unique'       => '电子邮箱已经存在',
                'email.required'     => '请输入电子邮箱',
                'password.required'  => '请输入登录密码',
                'type.required'      => '请选择帐号类型',
            ]);
            
            if ($validator->fails()) {
                $this->error($validator->errors()->first());
            }

            $user = User::create([
                'email'         => $request->email,
                'password'      => bcrypt($request->password),
                'register_time' => time(),
                'register_ip'   => $request->getClientIp(),
                'type'          => $request->type,
            ]);

            $user->userEmail()->save(new UserEmail([
                'email'    => $request->email
            ]));

            $this->sendEmailConfirmationTo($user);
            $this->success('注册成功', route('signin'));
        }
    }

    protected function sendEmailConfirmationTo(User $user)
    {   
        $view    = 'emails.confirm';
        $data    = compact('user');
        $to      = $user->email;
        $subject = sprintf("感谢注册 %s", setting('name'));
        
        // 使用phpmailer发送邮件
        // $this->sendEmail($view, $data, $to, $subject);

        /*
        Mail::send($view, $data, function ($message) use ($to, $subject) {
             $message->to($to)->subject($subject);
        });
        */

        dispatch(new SendEmail(['view' => $view, 'data' => $data, 'to' => $to, 'subject' => $subject]));
        session()->flash('success', '注册成功，请登录您的邮箱验证您的电子邮件');

    }
    
    // 激活邮箱后直接跳到登录页面
    public function confirmEmail(Request $request) {

        $userEmail = UserEmail::where('activation_token', $request->token)->where('email', $request->email)->firstOrFail();
        $userEmail->activated = true;
        // $userEmail->activation_token = null;
        $userEmail->save();

        session()->flash('success', '您的电子邮箱验证成功');
        return redirect()->route('signin');
    }

    public function logout() {
        return parent::_logout();
    }
}
