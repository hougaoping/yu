<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Validator;
use App\Models\Link;
use App\Http\Requests\LinkRequest;


class LinksController extends BaseController
{
	public function index(Request $request) {
        $link = new Link();
    	$list = $link->withOrder($this->_order())->withSearch($this->_keywords())->paginate($this->_rows());
    	return view('admin.links.index', compact('list'));
	}

	public function create(Request $request) {

		return view('admin.links.create_and_edit', ['status' => 1]);
	}

	public function store(LinkRequest $request) {

		$link = new Link;
		$link->fill($request->all());
        $link->save();

        $this->success('链接添加成功', route('admin.links.index'));
	}

	public function edit(Link $link) {
		$status = $link['status'];
		return view('admin.links.create_and_edit', compact('status', 'link'));
	}

	public function update(LinkRequest $request, Link $link) {
        $link->update($request->all());
        $this->success('链接更新成功', route('admin.links.index'));
	}

	public function destroy(Link $link) {
		$link->delete() && $this->success('链接删除成功');
	}
}
