<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use \App\Traits\Models\Order;

class Ad extends Model
{
    use Order, LogsActivity;

	protected $guarded = [];
	public $timestamps = true;

	protected static $logAttributes = ['id','name'];

	public function scopeWithOrder($query, $keywords = '')
    {
    	$this->withOrder($query, $keywords);
    }

    public function scopeWithSearch($query, $keywords = '', $ad_position_id = '') {
        !empty($keywords) && $query->where('name', 'like', '%' . $keywords . '%')->orWhere('intro', 'like', '%' . $keywords . '%');
		!empty($ad_position_id) && $query->where('ad_position_id', intval($ad_position_id));
    }
	
	public function position()
    {
        return $this->belongsTo('App\Models\AdPosition', 'ad_position_id');
    }
	
}