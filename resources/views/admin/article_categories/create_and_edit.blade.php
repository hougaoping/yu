@extends('admin.layouts.admin')

@section('content')
<div class="content-section">
    <div class="title-section mb-4 pb-4 border-bottom d-flex justify-content-between align-items-center">
        <h2>{{ isset($articleCategory['id']) ? '编辑文章分类' : '添加文章分类'}}</h2>
    </div>
    <div class="form-section">
        <form method="post" action="{{ isset($articleCategory['id']) ? route('admin.article_categories.update', $articleCategory['id']) : route('admin.article_categories.store') }}" class="form-aligned" autocomplete="off" id="form">
            {!! isset($articleCategory['id']) ? '<input type="hidden" name="_method" value="PUT">' : '' !!}
            {{ csrf_field() }}
				<div class="form-group row">
                    <label class="col-md-2 col-form-label text-sm-left text-md-right text-muted">所属文章分类：</label>
                    <div class="col-md-7 col-lg-5">
                        <select name="parent_id" class="form-control">
                            <option value="">请选择父级分类</option>
                            @foreach ($tree as $category)
                                <option @if(isset($articleCategory['parent_id']) && $category['id'] == $articleCategory['parent_id']) selected="selected" @endif value="{{ $category['id'] }}">{!! str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;", $category['level']) !!} {{ $category['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label text-sm-left text-md-right text-muted">文章分类名称：</label>
                    <div class="col-md-7 col-lg-5">
                        <input type="text" name="name" value="@isset($articleCategory['name']){{ $articleCategory['name'] }}@endisset" size="40" class="form-control">
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
				required : '请输入文章分类名称',
			},
		},
		submitHandler : function(){
			$('#form').ajaxPost();
		},
	});
});
@endpush