@extends('admin.layouts.admin')

@section('content')
<div class="form-wrapper">
    <div class="mb-4 pb-4 d-flex justify-content-between align-items-center">
        <h2>{{ isset($admin['id']) ? '编辑管理员' : '添加管理员'}}</h2>
    </div>
    <form method="post" action="{{ isset($admin['id']) ? route('admin.admin.update', $admin['id']) : route('admin.admin.store') }}" autocomplete="off" id="form">
        {!! isset($admin['id']) ? '<input type="hidden" name="_method" value="PUT">' : '' !!}
        {{ csrf_field() }}
        <div class="form-group row">
            <label for="input-name" class="col-md-2 col-form-label text-sm-left text-md-right text-muted">管理员姓名：</label>
            <div class="col-md-7 col-lg-5">
                <input type="text" name="name" id="input-name" value="@isset($admin['name']){{ $admin['name'] }}@endisset" class="form-control">
            </div>
        </div>
        <div class="form-group row">
            <label for="input-email" class="col-md-2 col-form-label text-sm-left text-md-right text-muted">电子邮件：</label>
            <div class="col-md-7 col-lg-5">
                <input type="text" name="email" id="input-email" value="@isset($admin['email']){{ $admin['email'] }}@endisset" class="form-control" placeholder="">
            </div>
        </div>
        <div class="form-group row">
            <label for="input-password" class="col-md-2 col-form-label text-sm-left text-md-right text-muted">登录密码：</label>
            <div class="col-md-7 col-lg-5">
                <input type="password" name="password" id="input-password" value="" class="form-control">
            </div>
        </div>
        <div class="form-group row">
            <label for="input-password-confirmation" class="col-md-2 col-form-label text-sm-left text-md-right text-muted">验证登录密码：</label>
            <div class="col-md-7 col-lg-5">
                <input type="password" name="password_confirmation" id="input-password-confirmation" value="" class="form-control">
            </div>
        </div>
        <div class="form-group row">
            <label for="" class="col-md-2 col-form-label text-sm-left text-md-right text-muted">所属角色：</label>
            <div class="col-md-10">
            @foreach ($adminRoles as $role)
                <div class="ickeck-box"><label for="role_{{ $role['id'] }}"><input name="admin_roles[]" value="{{ $role['id'] }}" id="role_{{ $role['id'] }}" type="checkbox" class="ickeck-input"
                        <?php
                        if (isset($hasRoles)) {
                            if(in_array($role['id'], $hasRoles)) {
                                echo ' checked="checked"';
                            }
                        }
                        ?>> {{ $role['name'] }} </label></div>
            @endforeach
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-7 col-lg-5 offset-md-2">
                <button type="submit" class="btn btn-primary" id="btn-submit">保存</button>
            </div>
        </div>
    </form>
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
		errorClass: "error", // 这玩意是添加到input中的
		errorPlacement:error_placment,
		rules : {
			name : {
				// required : true,
			},
            email : {
                required : true,
            },
		},
		messages : {
			name : {
				// required : '请输入管理员名称',
			},
            email : {
                required : '请输入电子邮件',
            },
		},
		submitHandler : function(){
			$('#form').ajaxPost();
		},
	});
});
@endpush
