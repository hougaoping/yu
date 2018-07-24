<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Setting;

class SettingsController extends BaseController
{
    
	public function index(Request $request) {
	    
	    if($request->isMethod('get')) {
	    	$settingsModel = new Setting;
            $settings = $settingsModel->pluck('value','key');
	    	return view('admin.settings.index', ['settings' => $settings]);
	    }else {
	    	// 处理保存和添加
			$settings = [];
			$settingsModel = new Setting();
			//找到数据表中原来拥有的字段
			$fields = $settingsModel->pluck('key')->toArray();

			foreach ($_POST as $name => $value) {
				if (preg_match('/^setting_/i', $name)) {
					$settings[substr($name, 8)] = $value;
				}
			}

			foreach ($settings as $key => $value) {
            	if (in_array($key, $fields)) {
                    $settingsModel->where('key', $key)->update(['value'=>$value]);
                } else {
                    $settingsModel->insert(['key'=>$key, 'value'=>$value]);
                }
            }

            activity()->log('更新设置');
			$this->success('设置保存成功', '', ['direct'=>false]);
	    }
	}
}
