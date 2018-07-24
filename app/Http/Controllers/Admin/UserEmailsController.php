<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Validator;
use App\Models\UserEmail;


class UserEmailsController extends BaseController
{

    protected function _activated() {
        return request()->has('activated') ? request()->input('activated') : '';
    }

	public function index(Request $request) {
        $userEmail = new UserEmail();
    	$list = $userEmail->withOrder($this->_order())->withSearch($this->_keywords(), $this->_activated())->paginate($this->_rows());

		$filter = [
            'activated' => [
                'yes' => ['route'=>'admin.user_emails.index',  'args' => ['activated' => 'yes'], 'name'=> '已验证'],
                'no'  => ['route'=>'admin.user_emails.index',  'args' => ['activated' => 'no'], 'name' => '未验证'],
            ],
        ];

    	return view('admin.user_emails.index', compact('list', 'filter'));
	}
}
