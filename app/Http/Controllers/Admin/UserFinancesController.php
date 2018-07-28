<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Validator;
use App\Models\UserFinance;


class UserFinancesController extends BaseController
{
	public function index(Request $request) {
        $userFinance = new UserFinance();
    	$list = $userFinance->withOrder($this->_order())->withSearch(request()->input('uid'), request()->input('enum'))->paginate($this->_rows());
        $enum_money = config('enum.money');

    	return view('admin.user_finances.index', compact('list', 'enum_money'));
	}
}
