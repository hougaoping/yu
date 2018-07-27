<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
<meta charset="utf-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>平台管理登录</title>
<link href="{{ asset('css/normalize.css') }}" rel="stylesheet">
<link href="{{ mix('css/admin.css') }}" rel="stylesheet">
<script src="{{ asset('js/jquery-1.12.4.js') }}"></script>
<script src="{{ mix('js/admin.js') }}"></script>
<style type="text/css">
html, body {
    height: 100%;
}
</style>
</head>

<body class="{{ route2class() }}-page login">
<div class="center-bg"></div>
<div class="center-box">
    <form autocomplete="" action="{{ route('admin.index') }}" method="post" id="form">
        {{ csrf_field() }}
        <h3 class="text-center">平台管理登录</h3>
        <div class="form-group">
            <input name="email" type="text" class="form-control email" placeholder="电子邮箱">
        </div>
        <div class="form-group">
            <input name="password" type="password" class="form-control password" placeholder="登录密码">
        </div>
        <div class="form-group clearfix">
            <input type="text" class="form-control captcha" name="captcha" placeholder="验证码">
            <span><img id="captcha" src="{{ captcha_src('flat') }}" onclick="this.src='/captcha/flat?' + Math.random()"></span>
        </div>
        <div class="form-group-controls">
            <input type="submit" class="btn btn-block btn-primary" id="submit" value="登录">
        </div>
    </form>
</div>

<script type="text/javascript">

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function(){
  if(!/chrome/i.test(navigator.userAgent)){
        alert('Please use the Google Chrome browser!');
        // history.back();
    }
});

function directURL(url, time) {
    if (time) {
        time = time * 1000;
    }
    if (url) {
        setTimeout(function(){
            window.location.href = url;
        }, time);
    }
}

$(function(){
    $('#submit').click(function(){
        var form = $('#form');
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            dataType: 'json',
            cache: false,
            data: form.serialize(),
            success: function(return_data) {
				directURL(return_data.url);
            },
			error: function(return_data) {
				if (return_data.status == 422) {
					var json = JSON.parse(return_data.responseText);
					alert(json.message);
				}
			},
		});
        return false;
    });
});

</script>
</body>
</html>
