<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use \App\Traits\Models\Order;
use \Spatie\Tags\HasTags;

class Article extends Model
{
	use Order, LogsActivity, HasTags;

	protected $guarded = [];
	public $timestamps = true;

	protected static $logAttributes = ['title'];

	public function scopeWithOrder($query, $keywords = '')
    {
    	$this->withOrder($query, $keywords);
    }

    public function scopeWithSearch($query, $keywords = '') {
        !empty($keywords) && $query->where('title', 'like', '%' . $keywords . '%');
    }

    // 获取最新文章
    public static function newest($limit = 10) {
        return self::where('status', 1)->limit($limit)->orderBy('id', 'desc')->get();
    }

	public function category()
    {
        return $this->belongsTo('App\Models\ArticleCategory', 'article_category_id');
    }
}