<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Validator;
use App\Models\UserCoin;


class UserCoinsController extends BaseController
{
	public function index(Request $request) {
        $userCoin = new UserCoin();
    	$list = $userCoin->withOrder($this->_order())->withSearch($request->uid, $request->enum, $request->start_time, $request->end_time)->paginate($this->_rows());
        $enum_coin = config('enum.coin');

    	return view('admin.user_coins.index', compact('list', 'enum_coin'));
	}
}
