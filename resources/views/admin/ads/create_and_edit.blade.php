@extends('admin.layouts.admin')

@section('content')
<div class="content-section">

    <div class="title-section mb-4 pb-4 d-flex justify-content-between align-items-center">
        <h2>{{ isset($ad['id']) ? '编辑广告' : '添加广告'}}</h2>
    </div>
    <div class="form-section">
    <form action="{{ isset($ad['id']) ? route('admin.ads.update', $ad['id']) : route('admin.ads.store') }}" method="post" id="form" enctype="multipart/form-data">
		{!! isset($ad['id']) ? '<input type="hidden" name="_method" value="PUT">' : '' !!}
		{{ csrf_field() }}

        <div class="form-group row">
            <label class="col-md-2 col-form-label text-sm-left text-md-right text-muted">所属广告位：</label>
            <div class="col-md-7 col-lg-5">
                <select name="ad_position_id" class="form-control dropdown">
                    <option value="">请选择一个广告位</option>
                    @foreach ($positions as $id => $name)
                    <option value="{{ $id }}"  @isset($ad['ad_position_id']) @if($id === $ad['ad_position_id']) selected="selected" @endif @endisset>{{ $name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-2 col-form-label text-sm-left text-md-right text-muted">广告名称：</label>
            <div class="col-md-7 col-lg-5">
               <input type="text" name="name" value="@isset($ad['name']){{ $ad['name'] }}@endisset" size="40" class="form-control">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-2 col-form-label text-sm-left text-md-right text-muted">广告简介：</label>
            <div class="col-md-7 col-lg-5">
                <textarea name="intro" class="form-control" rows="5">{{ isset($ad['intro']) ? $ad['intro'] : '' }}</textarea>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-2 col-form-label text-sm-left text-md-right text-muted">广告开始时间：</label>
            <div class="col-md-7 col-lg-5"><input type="text" name="start_time" value="{{ isset($ad['start_time']) ? $ad['start_time'] : date('Y/m/d H:i', time()) }}" size="40" class="date-picker form-control">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-2 col-form-label text-sm-left text-md-right text-muted">广告结束时间：</label>
            <div class="col-md-7 col-lg-5"><input type="text" name="end_time" value="{{ isset($ad['end_time']) ? $ad['end_time'] : date('Y/m/d H:i', time()) }}" size="40" class="date-picker form-control">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-2 col-form-label text-sm-left text-md-right text-muted">链接地址：</label>
            <div class="col-md-7 col-lg-5"><input type="text" name="url" value="{{ isset($ad['url']) ? $ad['url'] : 'http://' }}" size="40" class="form-control">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-2 col-form-label text-sm-left text-md-right text-muted">广告排序：</label>
            <div class="col-md-7 col-lg-5"><input type="text" name="order" value="{{ isset($ad['order']) ? $ad['order'] : '0' }}" size="40" class="form-control">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-2 col-form-label text-sm-left text-md-right text-muted">广告状态：</label>
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
            <label for="input-name" class="col-md-2 col-form-label text-sm-left text-md-right text-muted">广告图片：</label>
            <div class="col-md-10">
                @widget('upload', ['config'=>'ad', 'name'=>'picture', 'files'=> isset($ad['picture']) ? $ad['picture'] : ''])
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

@push('links')
<script src="/jq-upload/js/vendor/jquery.ui.widget.js"></script>
<script src="/jq-upload/js/jquery.iframe-transport.js"></script>
<script src="/jq-upload/js/jquery.fileupload.js"></script>
<link rel="stylesheet" href="/css/upload-widget.css"></link>
<script src="/js/upload-widget.js"></script>

@endpush

@push('scripts')

var uploadScript = <?php echo json_encode(route('admin.upload')) ?>;

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
            ad_position_id: {
                required : true,
            },
			name : {
				required : true,
			},
			start_time : {
				required : true,
			},
			end_time : {
				required : true,
			},
			url : {
				required : true,
				url      : true
			},
            order : {
                required : true,
            },
		},
		messages : {
            ad_position_id : {
                required : '请选择所属广告位',
            },
			name : {
				required : '请输入广告名称',
			},
			start_time : {
				required : '请输入广告起始时间',
			},
			end_time : {
				required : '请输入广告结束时间',
			},
			url : {
				required : '请输入广告链接地址',
				url : '错误的链接地址'
			},
            order : {
                required : '请输入排序数字',
            },
		},
		submitHandler : function(){
			$('#form').ajaxPost();
		},
	});
});
@endpush