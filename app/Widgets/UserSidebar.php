<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;

class UserSidebar extends AbstractWidget
{

    protected $config = [];

    public function run()
    {
        return view('widgets.user_sidebar', [
            'config' => $this->config,
        ]);
    }
}
