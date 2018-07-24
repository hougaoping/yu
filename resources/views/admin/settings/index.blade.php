@extends('admin.layouts.admin')
@section('content')
<div class="content-section">
	<div class="title-section mb-4 pb-4 border-bottom d-flex justify-content-between align-items-center">
    <h2>系统设置</h2>
  </div>

  <div class="form-section">
    <form method="post" action="" class="form-aligned" autocomplete="off" id="form">
        {{ csrf_field() }}
          <div class="form-group row">
            <label class="col-md-2 col-form-label text-sm-left text-md-right text-muted">站点名称：</label>
            <div class="col-md-7 col-lg-5">
                <input type="text" name="setting_name" value="@isset($settings['name']){{ $settings['name'] }}@endisset" size="40" class="form-control">
            </div>
          </div>
          <div class="form-group row">
            <label for="" class="col-md-2 col-form-label text-sm-left text-md-right text-muted">站点状态：</label>
            <div class="col-md-7 col-lg-5">
                <div class="ickeck-box">
                    <input type="radio" name="setting_status" id="enabled" value="1" class="ickeck-input" @isset($settings['status'])  @if ($settings['status'] == '1') checked="checked" @endif @endisset/>
                    <label for="enabled" class="form-check-label">启用</label>
                </div>
                <div class="ickeck-box">
                    <input type="radio" name="setting_status" id="disable" value="0" class="ickeck-input" @isset($settings['status']) @if ($settings['status'] == '0') checked="checked" @endif @endisset/>
                    <label for="disable" class="form-check-label">禁用</label>
                </div>
            </div>
          </div>
          <div class="form-group row">
                <div class="col-md-7 col-lg-5 offset-md-2">
                    <button type="submit" class="btn btn-primary">保存</button>
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
          setting_name : {
                required : true,
            },
        },
        messages : {
            setting_name : {
                required : '网站名称不能为空',
            },
        },

        submitHandler : function(){
          // null执行默认回调函数，不执行默认回调函数则传入空函数
          $('#form').ajaxPost(null).then(function(){
          }, function(){
              alert('HTTP request error');
          });
        },

        showErrors : function(errorMap, errorList) {
            this.defaultShowErrors();
            // switchTab(); // 切换设置选项卡，目前暂时没用
        }
    });
});

function switchTab() {
    $('.id-tabs').find('a').each(function(){
        var id = this.href.split('#')[1];
        var panel = $('#'+id);
        if(panel.length){
            var err = panel.find('input.error');
            if(err.length){
                $(".id-tabs").idTabs(id);
                return false;
            }
        }
    });
}

@endpush