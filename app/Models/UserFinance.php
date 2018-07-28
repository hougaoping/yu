<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Activitylog\Traits\LogsActivity;
use \App\Traits\Models\Order;

class UserFinance extends Model
{
	use Order, LogsActivity;

	public $timestamps = true;

	// protected $fillable = [];

	protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
		
	public function scopeWithSearch($query, $uid = '', $enum = '') {
        !empty($uid) && $query->where('user_id', $uid);
		!empty($enum) && $query->where('enum', $enum);
    }
	
	public function scopeWithOrder($query, $keywords = '')
    {
        $this->withOrder($query, $keywords);
    }
}
