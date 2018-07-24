<?php
namespace App\Http\Controllers\Users\Mobile;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use App\Models\User;
use App\Models\UserLoginlog;
use Auth;
use Mail;
use Validator;
use Egulias\mobileValidator\mobileValidator;
use Egulias\mobileValidator\Validation\RFCValidation;

class IndexController extends BaseController
{

    use ThrottlesLogins;

	public function __construct()
    {
        $this->middleware('auth', [            
            'except' => ['login', 'register', 'verify']
        ]);

        $this->middleware('guest', [
            'only' => ['login', 'register']
        ]);
    }

    public function username() {
        return 'mobile';
    }

	public function login(Request $request) {
        
        if($request->isMethod('get')) {
		  return view('users.mobile.login');
        } else {

            $this->incrementLoginAttempts($request);
            if($this->hasTooManyLoginAttempts($request)) {
                $seconds = $this->limiter()->availableIn(
                    $this->throttleKey($request)
                );
                $this->error(sprintf('操作太频繁，请 %s 秒后重试', $seconds));
            }

            $validator = Validator::make($request->all(), [
               'mobile' => 'required|mobile|max:11',
            ], [
                'mobile.required'    => '请输入手机号码',
                'password.required'  => '请输入登录密码',
            ]);
            
            if ($validator->fails()) {
                $this->error($validator->errors()->first());
            }

            $user = User::where('mobile', $request->mobile)->first();
            
            if (!$user) {
                $this->error('手机号码不存在');
            }
          
            if (Auth::attempt(['mobile' => $request->mobile, 'password' => $request->password])) {
                $request->session()->regenerate();
                session()->put('username', $request->mobile);
                session()->put('last_login_time', time());
                
                $user->incrementLoginCount();
                $user->recordLastLoginLog();
                $user->recordLoginLog($request->mobile, true);
                $this->success('登录成功');
            }else {
                $user->recordLoginLog($request->mobile, false);
                $this->error('手机号码和密码不匹配');
            }
        }
	} 
	
	public function register(Request $request) {
        if($request->isMethod('get')) {
            return view('users.mobile.register');
        }else {
            $validator = Validator::make($request->all(), [
                'mobile'   => 'required|mobile|unique:users',
                'verify'   => 'required',
                'password' => 'required|confirmed|min:6',
                'type'     => 'required'
            ], [
                'mobile.unique'       => '手机号码已经存在',
                'verify.required'     => '验证码不能为空',
                'mobile.required'     => '请输入手机号码',
                'password.required'   => '请输入登录密码',
                'type.required'       => '请选择帐号类型',
            ]);
            
            if ($validator->fails()) {
                $this->error($validator->errors()->first());
            }

            
            if (session()->get('mobile.verify') != $request->verify) {
                $this->error('短信验证码错误');
            }

            $user = User::create([
                'mobile'         => $request->mobile,
                'password'       => bcrypt($request->password),
                'register_time'  => time(),
                'register_ip'    => $request->getClientIp(),
                'type'           => $request->type,
            ]);

            $this->success('注册成功', route('signin.mobile'));
        }
    }

    public function verify() {
        if (empty($_POST['mobile'])) {
            $this->error('请先输入手机号码');
        }

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
            $this->error($message);
        }

        $this->success('手机验证短信发送成功');
    }
}
