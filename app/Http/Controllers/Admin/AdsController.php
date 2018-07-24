<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Validator;
use App\Models\Ad;
use App\Models\AdPosition;
use App\Http\Requests\AdRequest;


class AdsController extends BaseController
{
	protected function _ad_position_id() {
		return request()->has('ad_position_id') ? request()->input('ad_position_id') : '';
	}

	public function index(Request $request) {
        $ad = new Ad();
    	$list = $ad->with('position')->withOrder($this->_order())->withSearch($this->_keywords(), $this->_ad_position_id())->paginate($this->_rows());
    	$positions = AdPosition::pluck('name','id')->toArray();
    	return view('admin.ads.index', compact('list', 'positions'));
	}

	public function create(Request $request) {
		$positions = AdPosition::pluck('name','id')->toArray();
		return view('admin.ads.create_and_edit', ['status' => 1, 'positions' => $positions]);
	}

	public function store(AdRequest $request) {
        $data = $request->all();
		$ad = new Ad;
		$ad->fill($data);
        $ad->save();
        $this->success('广告添加成功', route('admin.ads.index'));
	}

	public function edit(Ad $ad) {
		$status = $ad['status'];
		$positions = AdPosition::pluck('name','id')->toArray();
		return view('admin.ads.create_and_edit', compact('status', 'ad', 'positions'));
	}

	public function update(AdRequest $request, Ad $ad) {
        $data = $request->all();
        $ad->update($data);
        $this->success('广告更新成功', route('admin.ads.index'));
	}

	public function destroy(Ad $ad) {
		$ad->delete() && $this->success('广告删除成功');
	}
}
