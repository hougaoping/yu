@extends('admin.layouts.admin')

@section('content')
<div class="content-section">
    <div class="title-section mb-4 pb-4 border-bottom d-flex justify-content-between align-items-center">
        <h2>{{ isset($article['id']) ? '编辑文章' : '添加文章'}}</h2>
    </div>
    <div class="form-section">
    <form action="{{ isset($article['id']) ? route('admin.articles.update', $article['id']) : route('admin.articles.store') }}" method="post" id="form">
		{!! isset($article['id']) ? '<input type="hidden" name="_method" value="PUT">' : '' !!}
		{{ csrf_field() }}

        <div class="form-group row">
            <label class="col-md-2 col-form-label text-sm-left text-md-right text-muted">文章分类：</label>
            <div class="col-md-7 col-lg-5">
                <select name="article_category_id" class="form-control dropdown">
                    <option value="">请选择文章分类</option>
                    @foreach ($tree as $category)
                    <option value="{{ $category['id'] }}" @isset($article['article_category_id']) @if($category['id'] === $article['article_category_id']) selected="selected" @endif @endisset>{!! str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;", $category['level']) !!} {{ $category['name'] }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-2 col-form-label text-sm-left text-md-right text-muted">文章标题：</label>
            <div class="col-md-7 col-lg-5">
               <input type="text" name="title" value="@isset($article['title']){{ $article['title'] }}@endisset" size="40" class="form-control">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-2 col-form-label text-sm-left text-md-right text-muted">文章标签：</label>
            <div class="col-md-7 col-lg-5">
               <input type="text" name="keywords" value="@isset($article['keywords']){{ $article['keywords'] }}@endisset" size="40" class="form-control">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-2 col-form-label text-sm-left text-md-right text-muted">点击次数：</label>
            <div class="col-md-7 col-lg-5">
               <input type="text" name="click" value="@isset($article['click']){{ $article['click'] }}@endisset" size="40" class="form-control">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-2 col-form-label text-sm-left text-md-right text-muted">显示时间：</label>
            <div class="col-md-7 col-lg-5">
               <input type="text" name="date_time" value="{{ isset($article['date_time']) ?  $article['date_time'] : date('Y/m/d h:i') }}" size="40" class="form-control date-picker">
            </div>
        </div>
        <div class="form-group row">
            <label for="editor" class="col-md-2 col-form-label text-sm-left text-md-right text-muted">文章内容：</label>
            <div class="col-md-10">
                <textarea name="content" class="form-control" rows="5" id="ck_content">{{ isset($article['content']) ? $article['content'] : '' }}</textarea>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-2 col-form-label text-sm-left text-md-right text-muted">文章状态：</label>
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

@push('links')
<script type="text/javascript" src="/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
tinymce.init({
    selector: "textarea",
    height:400,
    statusbar: false,
    language:'zh_CN',
    plugins: [
         "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
         "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
         "save table contextmenu directionality emoticons template paste textcolor"
    ],

    // tinymce upload
    images_upload_handler: function (blobInfo, success, failure) {
        var xhr, formData;

        xhr = new XMLHttpRequest();
        xhr.withCredentials = false;
        xhr.open('POST', <?php echo json_encode(route('admin.upload.tinymce', ['_token' => csrf_token()]))?>);

        xhr.onload = function() {
          var json;

          if (xhr.status != 200) {
            failure('HTTP Error: ' + xhr.status);
            return;
          }

          json = JSON.parse(xhr.responseText);

          if (!json || typeof json.url != 'string') {
            failure('Invalid JSON: ' + xhr.responseText);
            return;
          }

          success(json.url);
        };

        formData = new FormData();
        formData.append('file', blobInfo.blob(), blobInfo.filename());

        xhr.send(formData);
    }
 });
</script>

@endpush

@push('scripts')

// 设置触发表单事件
$(function(){
    $('#btn-submit').click(function(){
        $("[name=content]").val(CKEDITOR.instances.ck_content.getData());
    });
});

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
            title : {
                required : true,
            },
           
        },
        messages : {
            title : {
                required : '请输入文章标题',
            },
        },
        submitHandler : function(){
            $('#form').ajaxPost();
        },
    });
});

@endpush