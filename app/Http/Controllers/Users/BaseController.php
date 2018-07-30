<?php

namespace App\Http\Controllers\Users;
use App\Http\Controllers\FrontController;

class BaseController extends FrontController
{
    protected function _rows() {
        return 10;
    }
}
