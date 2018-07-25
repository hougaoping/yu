<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Validator;
use App\Models\Article;
use App\Http\Requests\ArticleRequest;
use App\Models\ArticleCategory;
use \App\Traits\Controllers\Tags;
use Carbon\Carbon;

class ArticlesController extends BaseController
{

    use Tags;

	public function index(Request $request) {
        $article = new Article();
    	$list = $article->with('category')->withOrder($this->_order())->withSearch($this->_keywords())->paginate($this->_rows());
    	return view('admin.articles.index', compact('list'));
	}

	public function create(Request $request) {
		return view('admin.articles.create_and_edit', ['status' => 1, 'tree' => get_tree(ArticleCategory::get()->toTree())]);
	}

	public function store(ArticleRequest $request) {
        $data = $request->all();
        $data['date_time'] = Carbon::parse($request->date_time);
		$article = new Article;
		$article->fill($data);
        $article->save();

        $article->attachTags($this->tagsToArray($request->keywords));
        $this->success('文章添加成功', route('admin.articles.index'));
	}

	public function edit(Article $article) {
		$status = $article['status'];
		$tree = get_tree(ArticleCategory::get()->toTree());
		return view('admin.articles.create_and_edit', compact('status', 'article', 'tree'));
	}

	public function update(ArticleRequest $request, Article $article) {
       	$data = $request->all();
        $data['date_time'] = Carbon::parse($request->date_time);
        $article->update($data);
        $article->syncTags($this->tagsToArray($request->keywords));
        $this->success('文章更新成功', route('admin.articles.index'));
	}

	public function destroy(Article $article) {
		$article->delete() && $this->success('文章删除成功');
	}
}
