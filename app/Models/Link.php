<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use \App\Traits\Models\Order;

class Link extends Model
{
    use Order, LogsActivity;

	protected $guarded = [];
	public $timestamps = true;

    protected static $logAttributes = ['id', 'name', 'url'];

	public function scopeWithOrder($query, $keywords = '')
    {
    	$this->withOrder($query, $keywords);
    }

    public function scopeWithSearch($query, $keywords = '') {
        !empty($keywords) && $query->where('name', 'like', '%' . $keywords . '%')->orWhere('class_key', 'like', '%' . $keywords . '%');
    }
}