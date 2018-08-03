@extends('layouts.app')
@section('title') {{ $title }} @stop
@section('content')
<div class="container articles">
    <div class="page-main row">
        <div class="sidebar col-md-3 col-12 order-1 order-md-2 mb-4">
            <div class="category-list">
                @foreach ($categories as $category)
                <a class="category-item {{ active_class(if_route('article.category') && if_route_param('category', $category->id)) }}"" href="{{ route('article.category', $category) }}" title="{{ $category->name }}">{{ $category->name }}</a>
                @endforeach
            </div>
        </div>
        <div class="col-md-9 col-12 order-2 order-md-1">
            <div class="content">
                <ul class="article_list">
					@foreach ($articles as $article)
					<li class="{{ !empty($article->picture) ? 'has-image': '' }}">
						<a href="{{ route('article.index', $article) }}" target="" title="{{ $article->title }}" class="h4">{{ $article->title }}</a>
                        <div class="description">
                            @if(!empty($article->picture))
                            <div class="image"><img src="{{ Widget::Url(['id'=>$article->picture]) }}"></div>
                            @endif
                            {{ Stringy\create(strip_tags($article->content))->first(70) }}
                        </div>
                        <i class="clearfix"></i>
						<div class="info">
                            <span class="time">{{ $article->date_time }}</span>
                            <span class="click_num"><i></i>{{ $article->click }}人阅读</span></div>
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
