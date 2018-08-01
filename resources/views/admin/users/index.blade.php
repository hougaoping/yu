@extends('admin.layouts.admin')
@section('content')
<div class="content-wrapper">
	<div class="pb-4 mb-4 d-flex justify-content-between align-items-center">
	    <h2>用户列表</h2>
	</div>
	<div class="row mb-4">
		<div class="col-md-5">
		    <form name="search" method="get" action="">
		    	<div class="input-group">
		        	<input name="keywords" type="text" class="search keywords form-control" value="{{ request()->input('keywords') }}" onclick="$(this).focus().select()" placeholder="关键字">
		        	<div class="input-group-append">
	    			<button class="btn btn-primary" type="submit">查询</button>
	  				</div>
		    	</div>
		    </form>
		</div>
	</div>
	<div class="mb-4">
		@widget('filter', ['filterMenus' => $filter])
	</div>
	<div class="list table-responsive">
	    <table class="table table-hover">
	        <thead>
		        <tr class="">
		        	<th>@widget('order', ['field' => 'id', 'title'=>'UID'])</th>
					<th>操作</th>
		            <th>邮箱地址</th>
		            <th>手机号码</th>
		            <th>余额</th>
					<th>@widget('order', ['field' => 'login_count', 'title'=>'登录'])</th>
					<th>最后登录IP</th>
		            <th>@widget('order', ['field' => 'last_login_time	', 'title'=>'最后登录时间'])</th>
					<th>@widget('order', ['field' => 'register_time', 'title'=>'注册时间'])</th>
	         	</tr>
	     	</thead>
		    @foreach ($list as $data)
	        <tr>
				<td>{{ $data->id }}</td>
				<td>	
					<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">操作</button>
			        <div class="dropdown-menu">
			        	<a class="dropdown-item" href="{{ route('admin.users.profile', ['id' => $data['id']]) }}">个人信息</a>
						<a class="dropdown-item" href="{{ route('admin.user_finances.index', ['uid' => $data['id']]) }}">财务明细</a>
						<a class="dropdown-item" href="{{ route('admin.user_coins.index', ['uid' => $data['id']]) }}">金币明细</a>
						<a class="dropdown-item" href="{{ route('admin.users.charge', ['id' => $data['id']]) }}">充值</a>
			        </div>
				</td>
				<td>
					{{ $data->email }}
				</td>
				<td>
					{{ $data->mobile }}
				</td>
				<td>
					{{ $data->amount }}
				</td>
				<td>
					{{ $data->login_count }}
				</td>
				<td>
					{{ $data->last_login_ip }}
				</td>
				<td>
					{{ date('Y/m/d H:i:s', $data->last_login_time) }}
				</td>
				<td>
					{{ date('Y/m/d H:i:s', $data->register_time) }}
				</td>
		    </tr>
		    @endforeach
	    </table>
	    @if ($list->isEmpty())
		    <div class="no-content">
	            查询不到相关记录
	        </div>
        @endif
	</div>
	@if ($list->hasPages())
	    <div class="pt-4 border-top d-flex justify-content-end align-items-center">
            {{ $list->appends($_GET)->links() }}
        </div>
	@endif
</div>
@stop
