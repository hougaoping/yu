<?php
namespace App\Http\Controllers\Articles;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Auth;
use Mail;
use Validator;
use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\RFCValidation;
use App\Models\Article;
use App\Models\ArticleCategory;

class IndexController extends BaseController
{
	public function category(ArticleCategory $category = null, Request $request) {

        if (!is_null($category)) {
            $title    = $category->name;
            $articles = $category->articles()->paginate($this->_rows());
        }else {
            $title    = '全部分类';
            $articles = Article::paginate($this->_rows());
        }
        
        $categories = ArticleCategory::where('parent_id', null)->get();
		return view('articles.category', compact('title', 'category', 'articles', 'categories'));
	}
	
	public function index(Article $article, Request $request) {
        if($article->status == 0) {
            abort(404);
        }
        
        $article->increment('click', 1);
        $newest = Article::where('status', 1)->limit(10)->orderBy('id', 'desc')->get();
		return view('articles.index', compact('article', 'newest'));
	} 
}