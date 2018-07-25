@extends('layouts.app')
@section('title') {{ $article->title }} @stop
@section('content')
<div class="container articles">
    <div class="page-main row">
        <div class="sidebar col-md-3 col-12 order-2">
            <div class="part">
            <h3>最新推荐</h3>
            <ul class="clearfix">
                @foreach ($newest as $article)
                <li><a href="{{ route('article.index', $article) }}" title="{{ $article->title }}">{{ $article->title }}</a></li>
                @endforeach
            </ul>
            </div>
        </div>
        <div class="col-md-9 col-12 order-1">
            <div class="content">
                <h1 class="title">{{ $article->title }}</h1>
                <div class="article-info">
                    <span>{{ $article->date_time }}</span>
                    <span><a title="" href="javascript:void(0);">{{ $article->category->name }}</a></span>
                    <span><a title="放大网页内容字体，方便阅读" href="javascript:void(0);" id="add_size">放大字体</a></span>
                </div>
                <div class="article-body">
                    {!!  $article->content !!}
                </div>
            </div>
        </div>
        
    </div>
</div>
@stop

@push('scripts')
$.fn.addSize = function (el, s) {
    this.one('click', function (){
        var size = parseInt($(el).css('font-size'), 10);
        if (size) {
            $('a', el).add(el).css('font-size', size + (s || 5))
        }
    })
};

$('#add_size').addSize('.article-body p', 3);
@endpush