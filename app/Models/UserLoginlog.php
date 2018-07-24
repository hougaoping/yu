<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \App\Traits\Models\Order;

class UserLoginlog extends Model
{
    use Order;

	protected $fillable = [
        'user_id', 'username', 'is_admin', 'result', 'login_time', 'ip','url'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function scopeWithOrder($query, $keywords = '')
    {
        $this->withOrder($query, $keywords);
    }

    public function scopeWithSearch($query, $keywords = '') {
        !empty($keywords) && $query->where('username', 'like', '%' . $keywords . '%');
    }
}