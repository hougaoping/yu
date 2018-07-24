<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Activitylog\Traits\LogsActivity;
use \App\Traits\Models\Order;

class UserEmail extends Model
{
	use Order, LogsActivity;

	protected $fillable = [
        'user_id', 'email', 'activation_token', 'activated',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($userEmail) {
            $userEmail->activation_token = str_random(30);
        });
    }

	public function scopeWithOrder($query, $keywords = '')
    {
        $this->withOrder($query, $keywords);
    }

    public function scopeWithSearch($query, $keywords = '', $activated = '') {
        
        !empty($keywords) && $query->where('email', 'like', '%' . $keywords . '%');

        if (!empty($activated)) {
            switch($activated) {
                case 'yes': 
                    $query->where('activated', '1');
                break;
                case 'no': 
                    $query->where('activated', '0');
                break;
            }
        }
    }
}