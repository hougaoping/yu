<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Activitylog\Traits\LogsActivity;
use \App\Traits\Models\Order;

class UserCoin extends Model
{
	use Order, LogsActivity;

	public $timestamps = true;

	// protected $fillable = [];

	protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function getTypeAttribute($value)
    {
        $enum_coin = config('enum.coin');
        return $enum_coin[$this->enum];
    }
		
	public function scopeWithSearch($query, $uid = '', $enum = '', $start_time = '', $end_time = '') {
        !empty($uid) && $query->where('user_id', $uid);
		!empty($enum) && $query->where('enum', $enum);

        if (!empty($start_time) && !empty($end_time)) {
            $query->whereBetween('created_at', [$start_time, $end_time]);
        }
    }
	
	public function scopeWithOrder($query, $keywords = '')
    {
        $this->withOrder($query, $keywords);
    }
}
