<?php

namespace App\Http\Controllers\Users;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;

class CoinsController extends BaseController
{
	public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('auth.single');
    }

    public function index(Request $request) {
        if($request->isMethod('get')) {
            return view('users.center.coins.index');
        } else {
            if (!$request->has('coins_radio')) {
                $this->error('请选择金币数量');
            }
            $this->success('金币购买成功');
        }
    }
}
