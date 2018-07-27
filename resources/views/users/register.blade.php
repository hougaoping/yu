@extends('layouts.app')
@section('title') 帐户注册 @stop
@section('content')

<div class="container container-min">
	<h1 class="title">
		注册{{ setting('name') }}
	</h1>
	<div class="form-wrapper">
		<form method="post" action="{{ route('signup') }}" autocomplete="" id="form">
			{{ csrf_field() }}
			<div class="form-group">
				<label for="email" class="label">电子邮箱</label>
				<input type="text" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="今后使用电子邮箱登录">
			</div>
			<div class="form-group">
				<label for="pwd" class="label">登录密码</label>
				<input type="password" class="form-control" id="pwd" name="password" value="{{ old('password') }}" placeholder="设置您的登录密码">
			</div>
			<div class="form-group">
				<label for="pwd2" class="label">确认密码</label>
				<input type="password" class="form-control" id="pwd2" name="password_confirmation" value="{{ old('password_confirmation') }}" placeholder="再次输入登录密码">
			</div>
			<div class="radio-box clearfix">
				<label class="input_radio seller float-left" for="seller"><input type="radio" name="type" value="seller" id="seller">注册商家帐号</label>
				<label class="input_radio buyer float-right" for="buyer"><input type="radio" name="type" value="buyer" id="buyer">注册买家帐号</label>
			</div>
			<div class="form-group-controls">
				<button type="submit" class="btn btn-primary btn-block" id="btn-submit">立即注册</button>
			</div>
			<p class="controls clearfix">
				<a href="{{ route('article.index', 1) }}" class="float-left" target="_blank">注册协议</a>
				<a href="{{ route('signin') }}" class="float-right">已有帐号, 立即登录</a>
			</p>
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
