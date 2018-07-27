@extends('admin.layouts.admin')
@section('content')
<div class="content-section">

<div class="table-responsive">
	<h3 class="h4 mt-3 mb-3">系统信息</h3>
	<table class="table table-hover">
		<tbody>
		<tr>
		  <td class="text-right text-muted">上传文件大小限制：</td>
		  <td>{{ $sys_info['upload_max_filesize'] }}</td>
		  <td class="text-right text-muted">服务器系统：</td>
		  <td>{{ $sys_info['os'] }}</td>
		  <td class="text-right text-muted">数据库版本：</td>
		  <td>{{ $sys_info['mysql_version'] }}</td>
		</tr>
		<tr>
		  <td class="text-right text-muted">是否支持REWRITE重写：</td>
		  <td>{{ $sys_info['rewrite_module'] }}</td>
		  <td class="text-right text-muted">SOCKET支持：</td>
		  <td>{{ $sys_info['socket'] }}</td>
		  <td class="text-right text-muted">服务器软件：</td>
		  <td>{{ $sys_info['webserver'] }} </td>
		</tr>
		<tr>
		  <td class="text-right text-muted">GD图形库支持：</td>
		  <td>{{ $sys_info['gd'] }}</td>
		  <td class="text-right text-muted">服务器所在时区：</td>
		  <td>{{ $sys_info['timezone'] }}</td>
		  <td class="text-right text-muted">服务器时间：</td>
		  <td>{{ $sys_info['date'] }}</td>
		</tr>
		<tr>
		  <td class="text-right text-muted">PHP版本信息：</td>
		  <td><a href="{{ action('Admin\DashboardController@index', ['phpinfo'=>'yes']) }}" target="_blank">查看</a></td>
		  <td class="text-right text-muted">占用内存：</td>
		  <td>{{ $sys_info['memory_info'] }}</td>
		  <td class="text-right text-muted">服务器空间占用：</td>
		  <td>{!! $sys_info['dirsize'] !!}</td>
		</tr>
		</tbody>
	</table>
</div>

</div>
@stop
