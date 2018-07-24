<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UploadController extends BaseController
{
    use \App\Traits\Controllers\Upload;
	public function index(Request $request) {
        if ($_POST['token'] == md5($_POST['time'] . $_POST['config'])) {
            return $this->_upload($_POST['config']);
        }
	}
    public function tinymce(Request $request) {
        return $this->_upload('editor', 'file');
    }
}
