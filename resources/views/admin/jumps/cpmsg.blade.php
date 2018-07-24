@extends('admin.layouts.admin')

@section('content')
<div class="content-section">
<div class="title-section d-flex justify-content-between align-items-center">
    <h2>操作通知</h2>
</div>
<div id="cpmsg" class="<?php echo $code == 0 ? 'error' : 'success'?>">
<?php switch ($code) {?>
<?php case 1:?>
	<h3><?php echo(strip_tags($message));?></h3>
	<?php break;?>
<?php case 0:?>
	<h3 class="fault"> <?php echo(strip_tags($message));?></h3>
	<?php break;?>
<?php } ?>
<dl>
  <dt><a href="<?php echo $url; ?>">页面将于 <b id="wait"> <?php echo $wait; ?> </b> 秒后自动跳转</a></dt>
  <dd><a id="href" href="<?php echo $url; ?>">返回上一个页面</a></dd>
</dl>
</div>
</div>
@stop

@push('scripts')
(function(){
var wait = document.getElementById('wait'),href = document.getElementById('href').href;
var interval = setInterval(function(){
	var time = --wait.innerHTML;
	if(time <= 0) {
		location.href = href;
		clearInterval(interval);
	}; 
}, 1000);
})();
@endpush