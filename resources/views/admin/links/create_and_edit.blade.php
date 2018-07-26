@extends('admin.layouts.admin')

@section('content')
<div class="content-section">
    <div class="title-section mb-4 pb-4 d-flex justify-content-between align-items-center">
        <h2>{{ isset($link['id']) ? '编辑链接' : '添加链接'}}</h2>
    </div>
    <div class="form-section">
        <form method="post" action="{{ isset($link['id']) ? route('admin.links.update', $link['id']) : route('admin.links.store') }}" autocomplete="off" id="form">
            {!! isset($link['id']) ? '<input type="hidden" name="_method" value="PUT">' : '' !!}
            {{ csrf_field() }}
            <div class="form-group row">
                <label class="col-md-2 col-form-label text-sm-left text-md-right text-muted">站点名称：</label>
                <div class="col-md-7 col-lg-5">
                    <input type="text" name="name" value="@isset($link['name']){{ $link['name'] }}@endisset" class="form-control">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label text-sm-left text-md-right text-muted">链接地址：</label>
                <div class="col-md-7 col-lg-5">
                    <input type="text" name="url" value="{{ isset($link['url']) ? $link['url'] : 'http://' }}" size="40" class="form-control">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label text-sm-left text-md-right text-muted">链接排序：</label>
                <div class="col-md-7 col-lg-5">
                    <input type="text" name="order" value="{{ isset($link['order']) ? $link['order'] : '0' }}" size="40" class="form-control">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label text-sm-left text-md-right text-muted">分类关键字：</label>
                <div class="col-md-7 col-lg-5">
                <input type="text" name="class_key" value="{{ isset($link['class_key']) ? $link['class_key'] : 'home' }}" size="40" class="form-control">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label text-sm-left text-md-right text-muted">状态：</label>
                <div class="col-md-7 col-lg-5">
                    <div class="ickeck-box">
                        <input type="radio" name="status" id="status_enabled" class="ickeck-input" value="1" @isset($status) @if($status==1) checked="checked" @endif @endisset>
                        <label for="status_enabled" class="form-check-label">启用</label>
                    </div>
                    <div class="ickeck-box">    
                        <input type="radio" name="status" id="status_disable" class="ickeck-input" value="0"  @isset($status) @if($status==0) checked="checked" @endif @endisset>
                        <label for="status_disable" class="form-check-label">禁用</label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-7 col-lg-5 offset-md-2">
                    <button type="submit" class="btn btn-primary" id="btn-submit">保存</button>
                </div>
            </div>
        </form>
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
		errorClass: "error", // 这玩意是添加到input中的
		errorPlacement:error_placment,
		rules : {
			name : {
				required : true,
			},
		   
			url : {
				required: true,
			},
		},
		messages : {
			name : {
				required : '请输入站点名称',
			},
			url : {
				required  : '请输入站点地址',
			},
		   
		},
		submitHandler : function(){
			$('#form').ajaxPost();
		},
	});
});
@endpush