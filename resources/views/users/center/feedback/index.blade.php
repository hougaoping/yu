@extends('layouts.app')
@section('title', '意见反馈')
@section('content')
<div class="center container clearfix">
    @include('users.layouts._sidebar')
    <div class="main-container">
        <div class="form-wrapper">
            <div class="header-line p-4 border-bottom">
                <h3>意见反馈</h3>
            </div>
            <form method="post" action="" class="" autocomplete="off" id="form">
                {{ csrf_field() }}
                <div class="form-group-wrapper">
                    <div class="form-group">
                        <label for="contact" class="label">联系方式：</label><input type="text" class="form-control" id="contact" name="contact" placeholder="请认真填写联系方式，我们将及时回复您">
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" id="description" name="description" rows="9" placeholder="欢迎提出宝贵意见和建议。我们将逐一回复，您的支持是我们最大的鼓励和帮助"></textarea>
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
            contact : {
                required : true,
            },
            description : {
                // required : true,
            },
        },
        messages : {
            contact : {
                required : '请填写联系方式',
            },
            description : {
                required : '请填写反馈内容',
            },
        },
        submitHandler : function(){
            $('#form').ajaxPost();
        },
    });
});

@endpush