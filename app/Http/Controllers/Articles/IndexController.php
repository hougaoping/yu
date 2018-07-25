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

class IndexController extends BaseController
{
	public function index(Article $article, Request $request) {
		return view('articles.index', compact('article'));
	} 
}
