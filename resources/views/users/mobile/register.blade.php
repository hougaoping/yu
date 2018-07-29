@extends('layouts.app')
@section('title') 帐户注册 @stop
@section('content')

<div class="container container-min">
	<h1 class="title">
		注册{{ setting('name') }}
	</h1>
	<div class="form-wrapper">
		<form method="post" action="{{ route('signup.mobile') }}" autocomplete="" id="form">
			{{ csrf_field() }}
			<div class="form-group">
				<label for="mobile" class="label">手机号码</label>
				<input type="text" class="form-control" id="mobile" name="mobile" value="{{ old('mobile') }}" placeholder="今后使用手机号码登录">
			</div>
			<div class="form-group">
				<label for="pwd" class="label">登录密码</label>
				<input type="password" class="form-control" id="pwd" name="password" value="{{ old('password') }}" placeholder="设置您的登录密码">
			</div>
			<div class="form-group">
				<label for="pwd2" class="label">确认密码</label>
				<input type="password" class="form-control" id="pwd2" name="password_confirmation" value="{{ old('password_confirmation') }}" placeholder="再次输入登录密码">
			</div>
			<div class="form-group">
				<label for="verify" class="label">短信验证</label>
				<input type="text" class="form-control" id="verify" name="verify" value="{{ old('verify') }}" placeholder="手机短信验证码">
				<span class="btn btn-primary get-verify" id="get-verify">获取验证码</span>
			</div>
			<div class="radio-box clearfix">
				<label class="input_radio seller float-left" for="seller"><input type="radio" name="type" value="seller" id="seller">注册商家帐号</label>
				<label class="input_radio buyer float-right" for="buyer"><input type="radio" name="type" value="buyer" id="buyer">注册买家帐号</label>
			</div>
			<div class="form-group-controls">
				<button type="submit" class="btn btn-primary btn-block" id="btn-submit">立即注册</button>
			</div>
			<p class="controls clearfix">
				<a href="{{ route('article.index', 1) }}" class="float-left" target="_blank">注册协议</a>
				<a href="{{ route('signin.mobile') }}" class="float-right">已有帐号, 立即登录</a>
			</p>
		</form>
	</div>
</div>
@stop

@push('links')
<style>
.form-group {
    position: relative;
}

.get-verify {
	position: absolute;
	right:0;
}
</style>
<script type="text/javascript">


!function(a,b){function d(){return"object"==typeof localStorage?localStorage:"object"==typeof globalStorage?globalStorage[location.href]:"object"==typeof userData?globalStorage[location.href]:{}}var c={userData:null,name:location.href,init:function(){if(!c.userData)try{c.userData=b.createElement("INPUT"),c.userData.type="hidden",c.userData.style.display="none",c.userData.addBehavior("#default#userData"),b.body.appendChild(c.userData);var a=new Date;a.setDate(a.getDate()+365),c.userData.expires=a.toUTCString()}catch(d){return!1}return!0},setItem:function(a,b){c.init()&&(c.userData.load(c.name),c.userData.setAttribute(a,b),c.userData.save(c.name))},getItem:function(a){return c.init()?(c.userData.load(c.name),c.userData.getAttribute(a)):void 0},removeItem:function(a){c.init()&&(c.userData.load(c.name),c.userData.removeAttribute(a),c.userData.save(c.name))}},e=d();a.storageExt={setItem:function(b,d){a.localStorage?e.setItem(b,d):c.setItem(b,d)},getItem:function(b){return a.localStorage?e.getItem(b):c.getItem(b)},removeItem:function(b){a.localStorage?e.removeItem(b):c.removeItem(b)}}}(window,document);


$(function(){
	var isCountdowning = false;
	function isHasPhoneNumber(){
		var num = $('#mobile').val();
		if(/^1\d{10}$/.test(num)){
			return true;
		}
		alert('请输入手机号码');
	}
	function sendCheckCode() {
		return $.ajax({
	        url: <?php echo json_encode(route('signup.mobile.verify'))?>,
	        type: 'POST',
	        dataType: 'json',
	        cache: false,
	        data: $('#form').serialize(),
	        success: function(return_data) {
	            alert(return_data['message']);
	        },
	        error: function(return_data) {
	        	var json = JSON.parse(return_data.responseText);
	            alert(json.message);
	        }
	    });
	}

	function getCountdownValue(){
	    var time = storageExt.getItem(location.pathname+'_prevreguser_');
	    if (/^\d{13}$/.test(time)) {
	        var next = parseFloat(time);
	        var cd = (next + 60*1000) - new Date() ;
	        if (cd > 0) {
	            return  parseInt( cd/1000, 10);
	        }
	    }
	    return false;
	}

	function startCountDown(time, el, isNew){
		if(isNew){
			storageExt.setItem(location.pathname+'_prevreguser_', +new Date());
		}
		isCountdowning = true;
		var timer;
		var self = $(el);
		var timeCount = time;
		var oldHTML = self.html();
		self.width(self.width()).addClass('disabled');
		function active(){
			timeCount--;
			if(timeCount > 0){
				self.html(timeCount + 's');
			}else{
				clearInterval(timer);
				self.html(oldHTML).removeClass('disabled');
				isCountdowning = false;
			}
		}
		active();
		timer = setInterval(active, 1000);
	}

	var isPrevRef = getCountdownValue();

	if(isPrevRef){
		startCountDown(isPrevRef, '#get-verify');
	}

	$('#get-verify').click(function(){
		if(isCountdowning || !isHasPhoneNumber()){
			return;
		}
		startCountDown(60, this, true);
		sendCheckCode();
	});
});
</script>

@endpush


@push('scripts')
$(function(){
    $('#btn-submit').click(function(){
        $('#form').ajaxPost();
        return false;
    });
});

@endpush
