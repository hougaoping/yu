@extends('admin.layouts.admin')

@section('content')

<div class="form-wrapper">
    <div class="mb-4 pb-4 d-flex justify-content-between align-items-center">
        <h2>{{ isset($adPosition['id']) ? '编辑广告位' : '添加广告位'}}</h2>
    </div>
    <form method="post" action="{{ isset($adPosition['id']) ? route('admin.ad_positions.update', $adPosition['id']) : route('admin.ad_positions.store') }}" class="form-aligned" autocomplete="off" id="form">
        {!! isset($adPosition['id']) ? '<input type="hidden" name="_method" value="PUT">' : '' !!}
        {{ csrf_field() }}
            <div class="form-group row">
                <label class="col-md-2 col-form-label text-sm-left text-md-right text-muted">广告位关键字：</label>
                <div class="col-md-7 col-lg-5">
                    <input type="text" name="name" value="@isset($adPosition['name']){{ $adPosition['name'] }}@endisset" size="40" class="form-control">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label text-sm-left text-md-right text-muted">广告位简介：</label>
                <div class="col-md-7 col-lg-5">
                    <textarea name="intro" class="form-control" rows="5">{{ isset($adPosition['intro']) ? $adPosition['intro'] : '' }}</textarea>
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
                <label for="input-classkey" class="col-md-2 col-form-label"></label>
                <div class="col-md-7 col-lg-5">
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
		errorElement: "span",
		ignore: "",
		onkeyup: false,
		errorClass: "error",
		errorPlacement:error_placment,
		rules : {
			name : {
				required : true,
			},
		},
		messages : {
			name : {
				required : '请输入广告位关键字',
			},
		},
		submitHandler : function(){
			$('#form').ajaxPost();
		},
	});
});
@endpush
