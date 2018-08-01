<?php

namespace App\Http\Controllers\Users\Center;
use App\Http\Controllers\FrontController;

class BaseController extends FrontController
{
    protected function _rows() {
        return 15;
    }
}
