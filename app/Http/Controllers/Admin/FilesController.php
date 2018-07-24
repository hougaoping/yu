<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Validator;
use App\Models\File;

class FilesController extends BaseController
{
	public function index(Request $request) {
        $files = new File();
    	$list = $files->withOrder($this->_order())->withSearch($this->_keywords())->paginate($this->_rows());
    	return view('admin.files.index', compact('list'));
	}
}
