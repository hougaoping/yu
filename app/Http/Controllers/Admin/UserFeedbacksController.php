<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Validator;
use App\Models\UserFeedback;


class UserFeedbacksController extends BaseController
{

	public function index(Request $request) {
        $userFeedback = new UserFeedback();
    	$list = $userFeedback->withOrder($this->_order())->paginate($this->_rows());
    	return view('admin.user_feedbacks.index', compact('list'));
	}
}
