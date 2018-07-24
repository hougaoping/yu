<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Validator;
use App\Models\AdPosition;
use App\Http\Requests\AdPositionRequest;


class AdPositionsController extends BaseController
{
	public function index(Request $request) {
        $adPosition = new AdPosition();
    	$list = $adPosition->withOrder($this->_order())->withSearch($this->_keywords())->paginate($this->_rows());
    	return view('admin.ad_positions.index', compact('list'));
	}

	public function create(Request $request) {
		return view('admin.ad_positions.create_and_edit', ['status' => 1]);
	}

	public function store(AdPositionRequest $request) {

		$adPosition = new AdPosition;
		$adPosition->fill($request->all());
        $adPosition->save();

        $this->success('广告位添加成功', route('admin.ad_positions.index'));
	}

	public function edit(AdPosition $adPosition) {
		$status = $adPosition['status'];
		return view('admin.ad_positions.create_and_edit', compact('status', 'adPosition'));
	}

	public function update(AdPositionRequest $request, AdPosition $adPosition) {

        $adPosition->update($request->all());
        $this->success('广告位更新成功', route('admin.ad_positions.index'));
	}

	public function destroy(AdPosition $adPosition) {
        if ($adPosition->ads()->count() > 0 ) {
            $this->error('该广告位下还有广告');
        }
		
        $adPosition->delete() && $this->success('广告位删除成功');
	}
}
