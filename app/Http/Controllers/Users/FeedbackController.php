<?php

namespace App\Http\Controllers\Users;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;

class FeedbackController extends BaseController
{
	public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('auth.single');
    }

    public function index(Request $request) {
        if($request->isMethod('get')) {
            return view('users.center.feedback.index');
        } else {
            if (empty($request->contact)) {
                $this->error('请填写联系方式');
            }
            if (empty($request->description)) {
                $this->error('请填写反馈内容');
            }
            Auth::user()->feedbacks()->create(['user_id'=>Auth::user(), 'contact'=>$request->contact, 'description'=>$request->description])->save();
            $this->success('保存成功', '', ['direct'=>false]);
        }
    }
}
