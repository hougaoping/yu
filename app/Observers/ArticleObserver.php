<?php
namespace App\Observers;
use App\Models\Article;
use \App\Traits\Controllers\Tags;

class ArticleObserver
{
	use Tags;
    public function saving(Article $article) {
        $article->keywords = $this->trim_tags($article->keywords);
    }
}