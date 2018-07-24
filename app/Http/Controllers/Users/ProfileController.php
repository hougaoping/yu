<?php

namespace App\Http\Controllers\Users;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\UserProfile;

class ProfileController extends BaseController
{
	public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('auth.single');
    }

	public function index(Request $request) {

        if($request->isMethod('get')) {
            $profile = Auth::user()->userProfile;
            return view('users.center.profile.index', compact('profile'));
        } else {
            $data = [
                'user_id'      => Auth::id(),
                'name'         => $request->name,
                'gender'       => $request->gender,
                'mobile'       => $request->mobile,
                'qq'           => $request->qq,
                'wx'           => $request->wx,
                'intro'        => $request->intro,
                'address'      => $request->address
            ];

            if (Auth::user()->userProfile) {
                Auth::user()->userProfile()->update($data);
            }else {
                Auth::user()->userProfile()->create($data);
            }

            Auth::user()->name = !is_null($request->name) ? $request->name : '';
            Auth::user()->save();
            $this->success('保存成功', '', ['direct'=>false]);
        }
	}
}
