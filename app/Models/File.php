<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use \App\Traits\Models\Order;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class File extends Model
{
    use Order, LogsActivity;

	protected $guarded = [];
	public $timestamps = true;
	protected static $logAttributes = ['id', 'user_id', 'name'];

	public function scopeWithOrder($query, $keywords = '')
    {
    	$this->withOrder($query, $keywords);
    }

    public function scopeWithSearch($query, $keywords = '', $ad_position_id = '') {
        !empty($keywords) && $query->where('name', 'like', '%' . $keywords . '%');
    }

    public function url() {
        return Storage::disk($this->attributes['disk'])->url(str_replace('\\', '/', $this->attributes['savename']));
    }

    public function scopeWithFiles($query, $fids) {
        $fids = explode(',', $fids);
        if (!empty($fids)) {
            $query->whereIn('id', $fids)->orderByRaw(DB::raw("FIELD('id', " . implode(',', $fids) .')'));
        }
    }
}