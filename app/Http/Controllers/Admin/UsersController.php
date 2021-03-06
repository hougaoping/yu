<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Validator;
use App\Models\User;
use App\Models\UserFinance;
use Auth;

class UsersController extends BaseController
{
    protected function _type() {
        return request()->has('type') ? request()->input('type') : '';
    }

	public function index(Request $request) {
        $user = new User();
    	$list = $user->withOrder($this->_order())->withSearch($this->_keywords(), $this->_type())->paginate($this->_rows());
        $filter = [
            'type' => [
                'seller' => ['route'=>'admin.users.index',  'args' => ['type' => 'seller'], 'name' => '商家会员'],
                'buyer'  => ['route'=>'admin.users.index',  'args' => ['type' => 'buyer'],  'name' => '买家会员'],
                'admin'  => ['route'=>'admin.users.index',  'args' => ['type' => 'admin'],  'name' => '管理员'],
            ],
        ];
    	return view('admin.users.index', compact('list', 'filter'));
	}

    public function profile(User $user) {
        $profile = $user->userProfile;
        return view('admin.users.profile', compact('user', 'profile'));
    }

    public function charge(User $user, Request $request) {
        if($request->isMethod('get')) {
            $token = time();
            $request->session()->put('token', $token);
		    return view('admin.users.charge', compact('user', 'token'));
        } else {
            $token = $request->input('token');
            if(empty($request->session()->get('token')) || $request->session()->get('token') != $token) {
                return $this->error('请勿重复提交');
            }
            $request->session()->pull('token', null);

            DB::beginTransaction();
            try {
                $user->amount = $user->amount + $request->charge;
                $user->save();
                UserFinance::create(['user_id'=>$user->id, 'enum' => 'CHARGE_ADD', 'change' => $request->charge, 'description' => $request->description, 'amount' => $user->amount]);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                $this->error('充值失败');
            }

            $this->success('充值成功', route('admin.users.index'));
        }
    }

	public function destroy(User $user) {
        $user->userEmail()->delete();
		$user->delete() && $this->success('用户删除成功');
	}
}
