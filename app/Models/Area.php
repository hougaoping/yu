<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use \App\Traits\Models\Order;

class Area extends Model
{
    use Order, LogsActivity;

	protected $guarded = [];
	public $timestamps = false;
}