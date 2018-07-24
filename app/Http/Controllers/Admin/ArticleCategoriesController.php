<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Validator;
use App\Models\ArticleCategory;


class ArticleCategoriesController extends BaseController
{
	public function index(Request $request) {
		$tree = get_tree(ArticleCategory::get()->toTree());
		return view('admin.article_categories.index', ['tree' => $tree]);
	}

	public function create(Request $request) {
		return view('admin.article_categories.create_and_edit', ['tree' => get_tree(ArticleCategory::get()->toTree())]);
	}

	public function store(Request $request) {

		$node = ['name'=>$request->name];
		if ($request->parent_id) {
			$parent = ArticleCategory::find($request->parent_id);
			$parent->appendNode(ArticleCategory::create($node));
		}else {
			ArticleCategory::create($node);
		}

        $this->success('文章分类添加成功', route('admin.article_categories.index'));
	}

	public function edit(ArticleCategory $articleCategory) {
		return view('admin.article_categories.create_and_edit', ['articleCategory' => $articleCategory,'tree' => get_tree(ArticleCategory::get()->toTree())]);
	}

	public function update(Request $request, ArticleCategory $articleCategory) {
		try {
			$articleCategory->parent_id = $request->parent_id;
			$articleCategory->save();
		} catch(\LogicException $e) {
			$this->error('父级分类不能是当前分类或者当前子分类');
		}
		
       $this->success('文章分类保存成功', route('admin.article_categories.index'));
	}

	public function destroy(ArticleCategory $articleCategory) {
		$articleCategory->delete() && $this->success('文章分类删除成功');
	}
}
