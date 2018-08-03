<?php

namespace App\Http\Controllers\Articles;
use App\Http\Controllers\FrontController;

class BaseController extends FrontController
{
    protected function _rows() {
        return 10;
    }
}
