<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', '')-{{ setting('name') }}</title>
<link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
<link href="{{ mix('css/app.css') }}" rel="stylesheet">
<script src="{{ mix('js/app.js') }}"></script>
<script src="{{ asset('js/jquery.validate.js') }}"></script>
<link href="{{ asset('js/message/message.css') }}" rel="stylesheet">
<script src="{{ asset('js/message/message.js') }}"></script>
<script src="{{ asset('js/ajaxPost.js') }}"></script>
<link href="{{ asset('js/icheck/skins/minimal/minimal.css') }}" rel="stylesheet">
<script src="{{ asset('js/icheck/icheck.js') }}"></script>
<!--
<script src="{{ asset('js/open.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/fontawesome/css/all.css') }}"></link>
<script defer src="{{ asset('css/fontawesome/js/all.js') }}"></script>
<link rel="stylesheet" type="text/css" href="/js/fancybox/dist/jquery.fancybox.min.css">
<script src="/js/fancybox/dist/jquery.fancybox.min.js"></script>
<link rel="stylesheet" href="{{ asset('js/hint.css/hint.min.css') }}"></link>
<link href="{{ asset('js/jQuery.mmenu/dist/jquery.mmenu.all.css') }}" rel="stylesheet">
<script src="{{ asset('js/jQuery.mmenu/dist/jquery.mmenu.all.js') }}"></script>
-->

@stack('links')
</head>

<body class="{{route2class()}}-page">
@includeWhen(isset($header) ? $header : true, 'layouts._header')
@yield('content')
@includeWhen(isset($footer) ? $footer : true, 'layouts._footer')
</body>
</html>

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

@stack('scripts')
</script>

@include('flashy::message')
