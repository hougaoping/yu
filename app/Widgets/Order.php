<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use Illuminate\Support\Str;


class Order extends AbstractWidget
{
	
    protected $config = [];

    public function run()
    {
        return $this->orderAction($this->config['field'], $this->config['title']);
    }

	public function orderAction($field, $name)
	{
        $path = \Route::current()->uri();

		$order = $field.'-asc';
		$class = 'sort';
		$orderValue = '';
		$_field = '';
		if(isset($_GET['order']))
			list($_field, $orderValue) = explode('-',  urldecode($_GET['order']));

		if ($field == $_field) {
			if ($orderValue == 'desc') {
				$class .= ' sort-down';
				$order = $_field.'-asc';
			}else if ($orderValue == 'asc') {
				$class .= ' sort-up';
				$order = $_field.'-desc';
			}
		}

		$url =  url($path . (Str::contains($path, '?') ? '&' : '?') . http_build_query(array_merge($_GET, ['order' => $order])));
		return '<a href="'.$url.'">'.$name.'</a><i class="'.$class.'"></i>';
	}
}
