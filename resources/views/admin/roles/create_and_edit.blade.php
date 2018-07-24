@extends('admin.layouts.admin')

@section('content')
<div class="content-section">
    <div class="title-section mb-4 pb-4 border-bottom d-flex justify-content-between align-items-center">
        <h2>{{ isset($role['id']) ? '编辑角色' : '添加角色'}}</h2>
    </div>
    <div class="form-section">
        <form method="post" action="{{ isset($role['id']) ? route('admin.roles.update', $role['id']) : route('admin.roles.store') }}" autocomplete="off" id="form">
            {!! isset($role['id']) ? '<input type="hidden" name="_method" value="PUT">' : '' !!}
            {{ csrf_field() }}
            <div class="form-group row">
                <label for="input-name" class="col-md-2 col-form-label text-sm-left text-md-right text-muted">角色名称：</label>
                <div class="col-md-7 col-lg-5">
                    <input type="text" name="name" id="input-name" value="@isset($role['name']){{ $role['name'] }}@endisset" class="form-control">
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-md-2 col-form-label text-sm-left text-md-right text-muted">角色权限：</label>
                <div class="col-md-10">
                    <div class="checkboxs">
                        @foreach ($permissions as $permission)
                        <dl>
                            <dt><span class="ctrl-box"><label><input type="checkbox"><i></i><u>{{ $permission['name'] }}</u></label></span></dt>
                            <dd>
                                <ul>
                                @foreach ($permission['items'] as $route => $name)
                                <li><span class="ctrl-box"><label><input type="checkbox" name="permissions[]" value="{{ $route }}" <?php
                                if (isset($role['permissions'])) {
                                    if (strpos($route, '|')) {
                                        $hasMany = explode('|', $route);
                                        foreach ($hasMany as $_route) {
                                            if (in_array($_route, json_decode($role['permissions']))) {
                                                echo ' checked="checked"';
                                            }
                                            break;
                                        }
                                    }else {
                                        if (in_array($route, json_decode($role['permissions']))) {
                                            echo ' checked="checked"';
                                        }
                                    }
                                }
                                ?>><i></i><u>{{ $name }}</u></label></span></li>
                                @endforeach
                                </ul>
                            </dd>
                        </dl>
                       @endforeach
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
<link href="/css/admin_role.css" rel="stylesheet" type="text/css">
@endpush

@push('scripts')

$(function (){
    checkboxSetter = {
        init: function (el){
            var owner = this;
            this.el = $(el);
            this.el.find('dt input:checkbox').click(function (){
                owner.selectAllSub(this);
                label = $(this).closest('label').removeClass('s-some');
            });
            this.el.find('li input:checkbox').click(function (){
                owner.update2State(this);
            });
            this.el.find('li').each(function (){
                var chk = $('input:checkbox', this).eq(0);
                owner.update2State(chk);
            });
        },

        selectAllSub: function (chk){
            var dl = $(chk).closest('dl');
            dl.find('dd input:checkbox').prop('checked', chk.checked);
            this.update1State(chk);
        },

        update2State: function (chk){
            var allSub = $(chk).closest('ul').find('input:checkbox');
            var box = $(chk).closest('dl');
            var parent = box.children('dt').find('input:checkbox');
            var label = parent.closest('label');
            var ed = allSub.filter(':checked').length;
            var isAll = ed == allSub.length;
            var css = "s-some";
            parent.prop('checked', isAll);
            if(box.find(':checked').length && !isAll){
                label.addClass(css);
            }else{
                label.removeClass(css);
            }
            this.update1State(parent);
        },

        update1State: function (chk){
            var allSub = $(chk).closest('dd').find('dt input:checkbox');
            var box = $(chk).closest('dd').closest('dl');
            var parent = box.children('dt').find('input:checkbox');
            var label = parent.closest('label');
            var ed = allSub.filter(':checked').length;
            var isAll = ed == allSub.length;
            var css = "s-some";
            parent.prop('checked', isAll);
            if(box.find(':checked').length && !isAll){
                label.addClass(css);
            }else{
                label.removeClass(css);
            }
        }
    };
    checkboxSetter.init('form');
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
			name : {
				required : true,
			},
		  
		},
		messages : {
			name : {
				required : '请输入角色名称',
			},
			
		},
		submitHandler : function(){
			$('#form').ajaxPost();
		},
	});
});
@endpush