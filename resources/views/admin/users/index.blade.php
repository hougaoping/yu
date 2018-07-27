@extends('admin.layouts.admin')
@section('content')
<div class="content-section">
	<div class="title-section pb-4 mb-4 d-flex justify-content-between align-items-center">
	    <h2>用户列表</h2>
	</div>
	<div class="action-section row mb-4">
		<div class="col-md-5">
		    <form name="search" method="get" action="">
		    	<div class="input-group">
		        	<input name="keywords" type="text" class="search keywords form-control" value="{{ request()->input('keywords') }}" onclick="$(this).focus().select()" placeholder="搜索关键字">
		        	<div class="input-group-append">
	    			<button class="btn btn-primary" type="submit">搜索</button>
	  				</div>
		    	</div>
		    </form>
		</div>
	</div>
	<div class="action-section mb-4">
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
		            <th>邮箱验证</th>
		            <th>@widget('order', ['field' => 'last_login_time	', 'title'=>'最后登录时间'])</th>
		            <th>@widget('order', ['field' => 'login_count', 'title'=>'登录次数'])</th>
					<th>@widget('order', ['field' => 'register_time', 'title'=>'注册时间'])</th>
					<th>最后登录IP</th>
	         	</tr>
	     	</thead>
		    @foreach ($list as $data)
	        </tr>
				<td>{{ $data->id }}</td>
				<td>
					<a class="opt" href="{{ route('admin.users.profile', ['id' => $data['id']]) }}">用户信息</a>
		            <!-- <span class="opt-separator"> | </span> -->
				</td>
				<td>
					{{ $data->email }}
				</td>
				<td>
					{{ $data->mobile }}
				</td>
				<td>
					@isset($data->userEmail)
						@if ($data->userEmail->activated == 1)
						  已验证
						@else
						  未验证
						@endif
					@endisset
				</td>
				<td>
					{{ date('Y/m/d H:i:s', $data->last_login_time) }}
				</td>
				<td>
					{{ $data->login_count }}
				</td>
				<td>
					{{ date('Y/m/d H:i:s', $data->register_time) }}
				</td>
				<td>
					{{ $data->last_login_ip }}
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
	    <div class="pagination-wrapper">
            {{ $list->appends($_GET)->links() }}
        </div>
	@endif
</div>
@stop
