<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;

class Filter extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        return $this->filterMenusAction($this->config['filterMenus']);
    }

	public function filterMenusAction($filterMenus) {
		$_filterHTML = '';
		$_i = 0;
		$_hasParam = 0;

		foreach($filterMenus as $key => $_filterMenus) {
			foreach($_filterMenus as $k=>$v) {	
				if(isset($_GET[$key]) && !$_hasParam){
					$_hasParam = $k == 	$_GET[$key];
				}
			}
		}

		foreach($filterMenus as $key => $_filterMenus) {
			$_filterHTML .= '<div class="btn-group d-flex">';
			foreach($_filterMenus as $k=>$v) {
				$_has = false;
				if($_hasParam){
					if(isset($_GET[$key])){
						$_has = $k == $_GET[$key];
					}
				}else{
					$_has = $_i == 0;
				}
				
				$_i++;
				$_class = $_has ? 'btn btn-outline-primary active' : 'btn btn-outline-primary';

				$badge = '';
				if (isset($v['function']) && is_callable($v['function'])) {
					$badge = $v['function']();
				}
				$_filterHTML .= '<a class="'.$_class.'" href="' . route($v['route'], $v['args']) . '">'.$v['name'] . $badge . '</a>';
			}
			$_filterHTML .= '</div>';
		}
		return $_filterHTML;
	}
}
