<?php

namespace App\Http\Controllers;

class AreaController extends Controller
{
	public function index() {
		$pid = request()->pid;
		$area = new \App\Models\Area();
		return $area->where('pid', $pid)->get();
	}
}
