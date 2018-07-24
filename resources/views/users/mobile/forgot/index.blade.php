@extends('layouts.app')
@section('title')忘记密码@stop
@section('content')
	<div class="container container-min">
		<h1 class="title">手机找回密码</h1>
		@unless((count($errors) > 0) || session()->has('danger') || session()->has('warning') || session()->has('success') || session()->has('info'))
			<p class="text-center text-muted reminder">请输入您的手机号码，我们将会发送一个短信验证码到你的手机用于找回密码。</p>
		@endunless
		<div class="form-wrapper padding-bottom">
			<form method="post" action="{{ route('forgot.mobile') }}" autocomplete="off" id="form">
				{{ csrf_field() }}
				<div class="form-group">
					<label for="mobile" class="label">手机号码</label>
					<input type="text" class="form-control" id="mobile" name="mobile" value="{{ old('mobile') }}" placeholder="您的手机号码">
				</div>
				<div class="form-group-controls">
					<button type="submit" class="btn btn-primary btn-block" id="btn-submit">发送验证短信</button>
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