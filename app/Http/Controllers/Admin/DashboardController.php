<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DashboardController extends BaseController
{
    private function _mysql_version()
    {
        $version = Db::select("select version() as ver");
        return ($version[0])->ver;
    }

	public function index(Request $request) {
	   
	    if (isset($_GET['phpinfo'])) {
	        phpinfo();
	        return;
	    }
	    
	    $rewrite_module = function_exists('apache_get_modules') ? apache_get_modules() : [];
	    $sys_info = [
	        'os'                  => PHP_OS,
	        'mysql_version'	      => $this->_mysql_version(),
	        'memory_info'	      => function_exists('memory_get_usage') ? get_real_size(memory_get_usage()) : '',
	        'rewrite_module'      => in_array('mod_rewrite', $rewrite_module) ? 'Yes' : 'No',
	        'socket'              => function_exists('fsockopen') ? 'Yes' : 'No',
	        'gd'                  => extension_loaded("gd") ? 'Yes' : 'No',
	        'upload_max_filesize' => ini_get('upload_max_filesize'),
	        'webserver'           => $_SERVER['SERVER_SOFTWARE'],
	        'timezone'            => config('app.timezone'),
	        'date'                => date($format = "Y/m/d H:i:s", time()),
	        'dirsize'             => '<a onclick="return confirm(\'可能会占用太多资源，请小心操作！\')" href="'. action('Admin\DashboardController@index', ['dirsize'=>1]) .'">查看</a>',
	    ];

	    if(request()->get('dirsize') == '1') $sys_info['dirsize'] =  get_real_size(dirsize(base_path()));
		return view('admin.dashboard.index', compact('sys_info'));
	}
}
