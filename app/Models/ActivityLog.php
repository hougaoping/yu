<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \App\Traits\Models\Order;

class ActivityLog extends Model
{
	use Order;

	protected $guarded = [];
	public $timestamps = false;
	protected $table = 'activity_log';

	public function scopeWithOrder($query, $keywords = '')
    {
    	$this->withOrder($query, $keywords);
    }

	public function scopeWithSearch($query, $keywords = '') {
        !empty($keywords) && $query->where('description', 'like', '%' . $keywords . '%')->orWhere('subject_type', 'like', '%' . $keywords . '%');
    }
}