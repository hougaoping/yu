<?php

namespace App\Http\Controllers\Users;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\UserFinance;
use App\Models\UserCoin;


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
            
             // 计算所需费用
            $money = $request->coins_radio + ((float) setting('money_coins_percent') / 100) * $request->coins_radio;
            if (Auth::user()->amount < $money) {
                $this->error('余额不足');
            }

            DB::beginTransaction();
            try {

                Auth::user()->coin = Auth::user()->coin + $request->coins_radio;
                Auth::user()->amount = Auth::user()->amount - $money;
                Auth::user()->save();
                UserCoin::create(['user_id' => Auth::user()->id, 'causer_type' => Auth::user()->getMorphClass(), 'causer_id' => Auth::id(), 'enum' => 'BUY_COIN', 'change' => $request->coins_radio, 'description' => '购买金币', 'coin' => Auth::user()->coin]);
                UserFinance::create(['user_id' => Auth::user()->id, 'causer_type' => Auth::user()->getMorphClass(), 'causer_id' => Auth::id(), 'enum' => 'BUY_COIN', 'change' => -1 * $money, 'description' => '购买金币', 'amount' => Auth::user()->amount]);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                $this->error('购买失败，请联系客服人员');
            }

            $this->success('购买成功');
        }
    }
}
