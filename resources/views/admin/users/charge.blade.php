@extends('admin.layouts.admin')

@section('content')
<div class="content-wrapper">
    <div class="mb-4 pb-4 d-flex justify-content-between align-items-center">
        <h2>充值</h2>
        <a href="{{ route('admin.users.index') }}" class="btn btn-primary">用户列表</a>
    </div>
    <div class="form-wrapper">
        <form method="post" action="{{ route('admin.users.charge', $user['id'])}}" autocomplete="off" id="form">
            {{ csrf_field() }}
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="form-group row">
                <label class="col-md-2 col-form-label text-sm-left text-md-right text-muted">手机号码：</label>
                <div class="col-md-7 col-lg-5">
                    <input type="text" readonly name="mobile" class="form-control-plaintext" value="@isset($user['mobile']){{ $user['mobile'] }}@endisset">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label text-sm-left text-md-right text-muted">电子邮箱：</label>
                <div class="col-md-7 col-lg-5">
                    <input type="text" readonly name="email" class="form-control-plaintext" value="@isset($user['email']){{ $user['email'] }}@endisset">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label text-sm-left text-md-right text-muted">注册时间：</label>
                <div class="col-md-7 col-lg-5">
                    <input type="text" readonly name="mobile" class="form-control-plaintext" value="@isset($user['created_at']){{ $user['created_at'] }}@endisset">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label text-sm-left text-md-right text-muted">帐号类型：</label>
                <div class="col-md-7 col-lg-5">
                    <input type="text" readonly name="mobile" class="form-control-plaintext" value="@isset($user['created_at']){{ $user['type'] == 'seller' ? '商家会员' : '买家会员' }}@endisset">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label text-sm-left text-md-right text-muted">帐户金额：</label>
                <div class="col-md-7 col-lg-5">
                    <input type="text" readonly name="amount" id="userMonery" class="form-control-plaintext" value="@isset($user['amount']){{ $user['amount'] }}@endisset">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label text-sm-left text-md-right text-muted">充值后金额：</label>
                <div class="col-md-3">
                    <input type="text" readonly name="afterMonery" id="afterMonery" value="{{ isset($user['amount']) ? $user['amount'] : '0.00' }}" size="40" class="form-control-plaintext">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label text-sm-left text-md-right text-muted">充值金额：</label>
                <div class="col-md-5">
                    <input type="text"  name="charge" value="" size="40" class="form-control" data-money="{{ $user['amount'] }}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label text-sm-left text-md-right text-muted">操作备注：</label>
                <div class="col-md-5">
                    <textarea name="description" class="form-control" rows="4" placeholder="">{{ $user['description'] }}</textarea>
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
<script src="/js/ammountfix.js"></script>
@endpush

@push('scripts')
$(function() {
	$(function() {
	var el = $('input[name=charge]');
	el.ammountFix({
		// min: 10,         // 最小值
        // defaultValue: '',
        // max: 50000,      // 最大值
		isMinus: true,      // 允许负号
		isFloat: true,      // 允许为小数
		digits: 2           // 小数点位数
	});

	el.keyup(function () {
    		var el = this;
    		setTimeout(function (){
    			var val = parseFloat(el.value) || 0;
    			var old = parseFloat(el.getAttribute('data-money')) || 0;
    			var after = (val + old).toFixed(2);
    			$('#afterMonery').val(after);
    		}, 0);
		});
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
			charge : {
				required : true,
			},
            description : {
				required : true,
			},
		},
		messages : {
			charge : {
				required : '请输入充值金额',
			},
            description: {
                required : '请输入操作备注',
            },
		},
		submitHandler : function(){
			$('#form').ajaxPost();
		},
	});
});
@endpush
