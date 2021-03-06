<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', '平台管理') - {{ setting('name') }}</title>
<link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
<link href="{{ mix('css/admin.css') }}" rel="stylesheet">
<script src="{{ mix('js/admin.js') }}"></script>
<script src="{{ asset('js/message/message.js') }}"></script>
<script src="{{ asset('js/address.js') }}"></script>
<script src="{{ asset('js/ajaxPost.js') }}"></script>
<script src="{{ asset('js/jquery.validate.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('js/datetimepicker/jquery.datetimepicker.css') }}">
<script src="{{ asset('js/datetimepicker/build/jquery.datetimepicker.full.min.js') }}"></script>
<link href="{{ asset('js/icheck/skins/minimal/minimal.css') }}" rel="stylesheet">
<script src="{{ asset('js/icheck/icheck.js') }}"></script>
<script src="{{ asset('js/idTabs.js') }}"></script>
<!--
<script src="{{ asset('js/js.cookie.js') }}"></script>
<script src="{{ asset('js/layer/layer.js') }}"></script>
<script src="{{ asset('js/open.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/fontawesome/css/all.css') }}"></link>
-->
@stack('links')
</head>

<body class="{{ route2class() }}-page">

@include('admin.layouts._sidebar')
<div class="main">
    @include('admin.layouts._header')
    <div class="content">
        @yield('content')
    </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
  $('.ickeck-input').iCheck({
    checkboxClass: 'icheckbox_minimal',
    radioClass: 'iradio_minimal',
    increaseArea: '20%' // optional
  });
});

$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});

$(function() {
    var close_sidebar   = $('#expand-sidebar');
    var sidebar         = $('.sidebar');
    var main            = $('.main');

    function toggleMenu(isHide) {
        var curIsHide = sidebar.is(':hidden');
        if (curIsHide) {
            var is_hidden = $(document).width() > 767 ? true : false;
            if (is_hidden) {
                main.removeClass('fully');
            }
            sidebar.show();
        } else {
            main.addClass('fully');
            sidebar.hide();
        }
    }

    close_sidebar.click(toggleMenu);
    $(window).resize(function() {
        var document_width = $(document).width();
        if (document_width > 767) {
            if (!main.hasClass('fully')) {
                sidebar.show();
            }
        }
    });
});

// 点击main关闭菜单
$.fn.hideWithClickOther = function (fn){
	 var self = this;
	 fn = fn || function(){return true};
     this.on('mousedown', function (e){
         e.stopPropagation();
     });
	 $(document).on('mousedown', function (){
		 if (fn()) {
			self.hide();
		 }
	 });
};

$('div.sidebar').hideWithClickOther(function (){
    return parseInt($('.main').css('left'), 10) < 1;
});

// 日期选择组件
$('.date-picker').datetimepicker();
$.datetimepicker.setLocale('zh');

@stack('scripts')
</script>
</body>
</html>
