@extends('layouts.app')
@section('title') {{ $article->title }} @stop
@section('content')
<div class="container articles">
    <div class="page-main row">
        <div class="sidebar col-md-3 col-12 order-2">
            
            
        </div>
        <div class="content col-md-9 col-12 order-1">
            <h1 class="title">{{ $article->title }}</h1>
            <div class="article-info">
                <span>2017-03-19 22:26</span>
                <span class="click_num">30人读过</span>
                <span><a title="放大网页内容字体，方便您阅读" href="javascript:void(0);" id="add_size">放大字体</a></span>
            </div>
            <div class="article-body">
                {!!  $article->content !!}
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