<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use Auth;

class AdminSidebar extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    public function run()
    {
		$sidebar = $this->sidebar(config('admin.sidebar'));
        return view('widgets.admin.sidebar', [
            'config' => $this->config,
			'sidebar'=> $sidebar
        ]);
    }
	
	protected function sidebar($sidebar) {
		foreach($sidebar as &$menu) {
			foreach($menu['items'] as &$item) {
				if (active_class(if_route_pattern($item['active']))) {
					$item['is_active'] = true;
					$menu['is_active'] = true;
				}
				if(permission(Auth::user(), $item['route'])) {
					$item['permission'] = true;
					$menu['permission'] = true;
				}
			}
		}
		
		return $sidebar; 
	}
}
