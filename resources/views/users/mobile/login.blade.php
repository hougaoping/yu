@extends('layouts.app')
@section('title') 帐户登录 @stop
@section('content')
	<div class="container container-min">
		<h1 class="title">登录{{ setting('name') }}</h1>
		@include('layouts._messages')
		<div class="form-wrapper">
			<form method="post" action="{{ route('signin.mobile') }}" autocomplete="" id="form">
				{{ csrf_field() }}
				<div class="form-group">
					<label for="mobile" class="label">手机号码</label>
			  		<input type="text" class="form-control" id="mobile" name="mobile" value="{{ old('mobile') }}" placeholder="您的手机号码">
				</div>
				<div class="form-group">
					<label for="pwd" class="label">登录密码</label>
			  		<input type="password" class="form-control" id="pwd" name="password" value="{{ old('password') }}" placeholder="输入登录密码">
				</div>
				<div class="remember-group">
			      	<div class="ickeck-box">
				      	<input type="checkbox" class="ickeck-input" id="remember-checkbox">
				      	<label class="label" for="remember-checkbox">保持登录状态</label>
			      	</div>
			    </div>
			    <div class="form-group-controls">
					<button type="submit" class="btn btn-primary btn-block" id="btn-submit">登录</button>
				</div>
				<p class="controls clearfix">
					<a href="{{ route('forgot.mobile') }}" target="_blank" class="float-left">忘记密码？</a>
					<a href="{{ route('signup.mobile') }}" target="" class="float-right">还没有帐号？注册一个</a>
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