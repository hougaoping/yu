@extends('layouts.app')

@section('title')重置密码@stop

@section('content')
	<div class="container container-min">
		<h1 class="title">重置密码</h1>
		@unless((count($errors) > 0) || session()->has('danger') || session()->has('warning') || session()->has('success') || session()->has('info'))
				<p class="text-center text-muted reminder">
					请设置 {{ $email }} 的新密码，建议使用数字、字母、字符的组合密码，提高密码安全等级
				</p>
		@endunless
		<div class="form-wrapper padding-bottom">
			<form method="post" action="{{ route('forgot.reset') }}" id="form">
				{{ csrf_field() }}
				<div class="form-group">
					<label for="password" class="label">登录密码</label>
					<input type="password" class="form-control" id="password" name="password" value="{{ old('password') }}" placeholder="请输入新登录密码">
				</div>
				<div class="form-group">
					<label for="password_confirmation" class="label">确认密码</label>
				  	<input type="password" class="form-control" id="password_confirmation" name="password_confirmation" value="{{ old('password_confirmation') }}" placeholder="再次输入新登录密码">
				</div>
				<div class="form-group-controls">
				<input type="hidden" name="email" value="{{ $email }}">
				<input type="hidden" name="token" value="{{ $token }}">
				<button type="submit" class="btn btn-primary btn-block" id="btn-submit">重置密码</button></div>
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