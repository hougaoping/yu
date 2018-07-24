<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\BackendController;
use Illuminate\Support\Facades\View;
use Auth;

class BaseController extends BackendController
{	
	public function __construct() {
        $this->middleware('admin');
        View::share('sidebar', config('admin.sidebar'));
    }

    protected function _keywords() {
        return request()->has('keywords') ? request()->input('keywords') : '';
    }
}
