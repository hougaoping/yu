@extends('layouts.app')
@section('title') {{ $category->name }} @stop
@section('content')
<div class="container articles">
    <div class="page-main row">
        <div class="sidebar col-md-3 col-12 order-1 order-md-2 mb-4">
            <div class="menu-list">
                @foreach ($categories as $category)
                <a class="list-item {{ active_class(if_route('article.category') && if_route_param('category', $category->id)) }}"" href="{{ route('article.category', $category) }}" title="{{ $category->name }}">{{ $category->name }}</a>
                @endforeach
            </div>
        </div>
        <div class="col-md-9 col-12 order-2 order-md-1">
            <div class="content">
                <ul class="article_list">
					@foreach ($articles as $article)
					<li>
						<a href="{{ route('article.index', $article) }}" target="_blank" title="">{{ $article->title }}</a>
						<p> {{ description($article->content, 120) }} </p> 
						<i class="clearfix"></i>
						<div class="info">
                            <span class="time">{{ $article->date_time }}</span>
                            <span class="click_num"><i></i>{{ $article->click }}人读过</span></div>
					</li>
					@endforeach
				</ul>
                @if ($articles->hasPages())
                    <div class="pagination-wrapper">
                        {{ $articles->appends($_GET)->links() }}
                    </div>
                @endif
            </div>
        </div>
        
    </div>
</div>
@stop