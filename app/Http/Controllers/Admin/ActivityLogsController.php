<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Validator;
use App\Models\ActivityLog;

class ActivityLogsController extends BaseController
{
	public function index(Request $request) {
        $activity = new ActivityLog();
    	$list = $activity->withOrder($this->_order())->withSearch($this->_keywords())->paginate($this->_rows());
    	return view('admin.activity_logs.index', compact('list'));
	}
}
