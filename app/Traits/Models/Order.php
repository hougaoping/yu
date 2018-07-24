<?php
namespace App\Traits\Models;
use Illuminate\Support\Facades\Schema;

trait Order
{
	// 根据 URl 参数自动排序
	protected function withOrder($query, $keywords = '')
    {
		$columns = Schema::getColumnListing($this->getTable());
	    if(is_string($keywords) && !empty($keywords)) { 
    		list($field, $value) = explode('-',  $keywords);
    		if (in_array($value, ['desc', 'asc']) && in_array($field, $columns)) {
    		    $query->orderBy($field, $value);
    		}
		}
    }
}