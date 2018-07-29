@extends('layouts.app')
@section('title', '修改密码')
@section('content')

<div class="center container clearfix">
    @include('users.layouts._sidebar')
    <div class="main-container">
        <div class="form-wrapper">
            <div class="header-line d-flex justify-content-between align-items-center border-bottom">
                <div class="tabs clearfix">
                    <a href="{{ route('center.password.index') }}" class="active">修改登录密码</a>
                    <a href="{{ route('center.password.safe_password') }}">修改安全密码</a>
                </div>
            </div>
            <form method="post" action="" class="" autocomplete="off" id="form">
                {{ csrf_field() }}
                <div class="form-group-wrapper">
                    <div class="form-group">
                        <label for="password_old" class="label">修改密码：</label><input type="password" class="form-control" id="password_old" name="password_old" placeholder="填写现用密码">
                    </div>
                        <div class="form-group">
                            <input type="password" class="form-control" id="password" name="password" placeholder="新登录密码">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" id="password_repeat" name="password_repeat" placeholder="再次输入登录密码">
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
            password_old : {
                required : true,
            },
            password : {
                required : true,
            },
            password_repeat : {
                required : true,
				equalTo:"#password"
            },
        },

        messages : {
            password_old : {
                required : '请填写现用密码',
            },
            password : {
                required : '请填写新的登录密码',
            },
            password_repeat : {
                required : '请重复输入登录密码',
				equalTo  : '两次密码必须一次',
            },
        },

        submitHandler : function(){
            $('#form').ajaxPost();
        },
    });
});


@endpush