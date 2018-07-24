@extends('layouts.app')
@section('title', '个人信息')

@section('content')
<div class="center container clearfix">
    @include('users.layouts._sidebar')
    <div class="main-container">
        <div class="form-wrapper">
            <div class="header-line border-bottom">
                <h3>个人信息</h3>
            </div>
            <form method="post" action="" class="" autocomplete="off" id="form">
                    {{ csrf_field() }}
                    <div class="form-group-wrapper">
                        <div class="form-group">
                            <label class="label" for="name">真实姓名：</label><input type="text" class="form-control" id="name" name="name" placeholder="填写真实姓名" value="@isset($profile['name']){{ $profile['name'] }}@endisset">
                        </div>
                        <div class="form-group">
                            <label class="label" for="gender">性别：</label><select id="gender" name="gender" class="form-control">
                                <option value="">未选择</option>
                                <option value="male" @isset($profile['gender']) @if ($profile['gender'] == 'male') selected="selected" @endif @endisset>男</option>
                                <option value="female" @isset($profile['gender']) @if ($profile['gender'] == 'female') selected="selected" @endif @endisset>女</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="label" for="mobile">手机号码：</label><input type="text" class="form-control" id="mobile" name="mobile" placeholder="填写常用手机号" value="@isset($profile['mobile']){{ $profile['mobile'] }}@endisset">
                        </div>
                        <div class="form-group">
                            <label class="label" for="qq">QQ号码：</label><input type="text" class="form-control" id="qq" name="qq" placeholder="填写常用QQ号码" value="@isset($profile['qq']){{ $profile['qq'] }}@endisset">
                        </div>
                        <div class="form-group">
                            <label class="label" for="wx">微信号码：</label><input type="text" class="form-control" id="wx" name="wx" placeholder="填写常用微信号码" value="@isset($profile['wx']){{ $profile['wx'] }}@endisset">
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-4">
                                    <label class="label" for="address">省份：</label>
                                    <select class="form-control address" id="address"><option>请选择</option></select>
                                </div>
                                <div class="col-4">
                                    <label class="label" for="city">城市：</label>
                                    <select class="form-control address" id="city"><option>请选择</option></select>
                                </div>
                                <div class="col-4">
                                    <label class="label" for="area">区域：</label>
                                    <select class="form-control address" id="area"><option>请选择</option></select>
                                </div>
                            </div>
                            <input type="hidden" name="address" value="@isset($profile['address']){{ $profile['address'] }}@endisset" id="_address">
                        </div>
                        <div class="form-group">
                            <label class="label" for="intro">个人简介：</label><textarea class="form-control" id="intro" name="intro" rows="5" placeholder="一句话介绍一下自己吧，让别人更了解你">@isset($profile['intro']){{ $profile['intro'] }}@endisset</textarea>
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


@push('links')
<script src="{{ asset('js/address.js') }}"></script>
@endpush

@push('scripts')

$(address('<?php echo route('areas')?>', $('.address'), $('#_address')));

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
            name : {
                required : true,
            },
            gender : {
                required : true,
            },
            mobile : {
                required : true,
            },
            qq : {
                required : true,
            },
            wx : {
                required : true,
            },
        },
        messages : {
            name : {
                required : '请填写真实姓名',
            },
            gender : {
                required : '请选择性别',
            },
            mobile : {
                required : '请填写手机号码',
            },
            qq : {
                required : '请填写QQ号码',
            },
            wx : {
                required : '请填写微信号码',
            },
        },
        submitHandler : function(){
            $('#form').ajaxPost();
        },
    });
});

@endpush