<?php

namespace App\Http\Controllers\Users;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\UserFinance;
use App\Exports\FinancesExport;
use Excel;

class FinancesController extends BaseController
{
	public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('auth.single');
    }

    public function index(Request $request) {
        $userFinance = new UserFinance();
        $list = $userFinance->withOrder($this->_order())->withSearch(Auth::id(), $request->enum, $request->start_time, $request->end_time)->paginate($this->_rows());
        $enum_money = config('enum.money');
        return view('users.center.finances.index', compact('list', 'enum_money'));
    }

    public function export(Excel $excel, Request $request) {
        return Excel::download(new FinancesExport(Auth::id()), 'finances.xlsx');
    }

    public function coins(Request $request) {
        return 'coin';
    }
}