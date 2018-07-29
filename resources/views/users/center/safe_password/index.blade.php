@extends('layouts.app')
@section('title', '安全密码')
@section('content')

<div class="center container clearfix">
    @include('users.layouts._sidebar')
    <div class="main-container">
        <div class="container-wrapper">
            <div class="header-line d-flex justify-content-between align-items-center border-bottom">
                <div class="tabs clearfix">
                    <a href="{{ route('center.password.index') }}">修改登录密码</a>
                    <a href="{{ route('center.password.safe_password') }}" class="active">修改安全密码</a>
                </div>
            </div>
            <form method="post" action="" class="" autocomplete="off" id="form">
                {{ csrf_field() }}
                <div class="form-group-wrapper">
                    <div class="form-group">
                        <label for="password" class="label">登录密码：</label>
                        <input type="password" class="form-control" id="login_password" name="login_password" placeholder="登录密码">
                    </div>
                    @if (!empty(Auth::user()->safe_password))
                    <div class="form-group">
                        <label for="old_safe-password" class="label">现用安全密码：</label>
                        <input type="password" class="form-control" id="old_safe-password" name="old_safe_password" placeholder="现用安全密码">
                    </div>
                    @endif
                    <div class="form-group">
                        <label for="safe-password" class="label">安全密码：</label>
                        <input type="password" class="form-control" id="safe-password" name="safe_password" placeholder="安全密码">
                        <small class="text-muted">安全密码不能和登录密码相同</small>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="password_repeat" name="safe_password_repeat" placeholder="再次输入安全密码">
                    </div>
                </div>
                <div class="form-group-controls border-top">
                    <button type="submit" class="btn btn-primary" id="btn-submit">保存</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop


@push('scripts')
var error_placment = function (error, element){
    $(element).after(error);
    $(error).addClass('invalid-feedback');
}

$(function(){
    //表单验证
    var vali = $('#form').validate({
        errorElement: "div",
        ignore: "",
        onkeyup: false,
        errorClass: "error",
        errorPlacement:error_placment,

        rules : {
            login_password : {
                required : true,
            },
            old_safe_password : {
                required : true,
            },
            safe_password : {
                required : true,
            },
            safe_password_repeat : {
                required : true,
				equalTo:"#safe-password"
            },
        },

        messages : {
            login_password : {
                required : '请填写登录密码',
            },
            old_safe_password : {
                required : '请填写现用安全密码',
            },
            safe_password : {
                required : '请填写安全密码',
            },
            safe_password_repeat : {
                required : '请重复输入安全密码',
				equalTo  : '两次密码必须一次',
            },
        },

        submitHandler : function(){
            $('#form').ajaxPost();
        },
    });
});

@endpush