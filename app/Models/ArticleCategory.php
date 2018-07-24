<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use \App\Traits\Models\Order;
use Kalnoy\Nestedset\NodeTrait;

class ArticleCategory extends Model
{
	use NodeTrait, Order, LogsActivity;

	protected $guarded = [];
	public $timestamps = true;

	protected static $logAttributes = ['name'];

	public function scopeWithOrder($query, $keywords = '')
    {
    	$this->withOrder($query, $keywords);
    }

    public function scopeWithSearch($query, $keywords = '') {
        !empty($keywords) && $query->where('name', 'like', '%' . $keywords . '%');
    }

    public function articles()
    {
        return $this->hasMany('App\Models\Article');
    }
}