@extends('layouts.app')
@section('title') {{ $category->name }} @stop
@section('content')
<div class="container articles">
    <div class="page-main row">
        <div class="sidebar col-md-3 col-12 order-2">
            <div class="part">
            <h3>文章分类</h3>
            <ul class="clearfix">
                @foreach ($categories as $category)
                <li><a href="{{ route('article.category', $category) }}" title="{{ $category->name }}">{{ $category->name }}</a>
                </li>
                @endforeach
            </ul>
            </div>
        </div>
        <div class="col-md-9 col-12 order-1">
            <div class="content">
                <ul class="article_list">
					@foreach ($articles as $article)
					<li>
						<a href="{{ route('article.index', $article) }}" target="_blank" title="">{{ $article->title }}</a>
						<p> {{ description($article->content, 170) }} </p> 
						<i class="clearfix"></i>
						<div class="info">
                            <span class="time">{{ $article->date_time }}</span>
                            <span class="click_num"><i></i>{{ $article->click }}人读过</span></div>
					</li>
					@endforeach
				</ul>
            </div>
        </div>
        
    </div>
</div>
@stop