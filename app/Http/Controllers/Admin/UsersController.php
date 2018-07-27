<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Validator;
use App\Models\User;


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
                'seller' => ['route'=>'admin.users.index',  'args' => ['type' => 'seller'], 'name'=> '卖家会员'],
                'buyer'  => ['route'=>'admin.users.index',  'args' => ['type' => 'buyer'], 'name' => '买家会员'],
                'admin'  => ['route'=>'admin.users.index',  'args' => ['type' => 'admin'], 'name' => '管理员'],
            ],
        ];

    	return view('admin.users.index', compact('list', 'filter'));
	}

    public function profile(User $user) {
        $profile = $user->userProfile;
        return view('admin.users.profile', compact('user', 'profile'));
    }

	public function destroy(User $user) {
        $user->userEmail()->delete();
		$user->delete() && $this->success('用户删除成功');
	}
}
