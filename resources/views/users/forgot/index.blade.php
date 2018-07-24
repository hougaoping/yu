@extends('layouts.app')

@section('title')忘记密码@stop

@section('content')
	<div class="container container-min">
		<h1 class="title">忘记密码</h1>
		@unless((count($errors) > 0) || session()->has('danger') || session()->has('warning') || session()->has('success') || session()->has('info'))
			<p class="text-center text-muted reminder">请输入您的电子邮箱，我们将会发送一个找回密码的链接到你的邮箱，通过该链接可以进入重置密码的页面。</p>
		@endunless
		<div class="form-wrapper padding-bottom">
			<form method="post" action="{{ route('forgot') }}" autocomplete="off" id="form">
				{{ csrf_field() }}
				<div class="form-group">
					<label for="email" class="label">电子邮箱</label>
					<input type="text" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="您的电子邮箱">
				</div>
				<div class="form-group-controls">
					<button type="submit" class="btn btn-primary btn-block" id="btn-submit">发送重置密码邮件</button>
				</div>
			</form>
			</div>
	</div>
@stop

@push('scripts')

$(function(){
    $('#btn-submit').click(function(){
        $('#form').ajaxPost();
        return false;
    });
});

@endpush