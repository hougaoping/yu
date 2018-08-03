<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use App\Models\File;

class Url extends AbstractWidget
{
  
    protected $config = [];
   
    public function run()
    {
        $file = File::where('id', intval($this->config['id']))->first();
        return $file ? $file->url() : '';
    }
}
