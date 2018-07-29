@extends('admin.layouts.admin')

@section('content')

<div class="content-section">
	<div class="title-section mb-4 pb-4">
	    <h2>登录日志</h2>
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
	
	<div class="list table-responsive">
	    <table class="table table-hover">
	        <thead>
		        <tr class="">
		        	<th>@widget('order', ['field' => 'id', 'title'=>'ID'])</th>
					<th>UID</th>
		            <th>用户名称</th>
		            <th>管理员</th>
		            <th>操作</th>
		            <th>URL</th>
		            <th>IP</th>
		            <th>时间</th>
				</tr>
			</thead>
			<tbody>
		    @foreach ($list as $data)
	        <tr>
	        	<td>{{ $data->id }}</td>
				<td>{{ $data->user_id }}</td>
				<td>{{ $data->username }}</td>
				<td>{{ $data->is_admin ? '是' : '否' }}</td>
				<td>{{ $data->result ? '成功' : '失败' }}</td>
				<td>{{ $data->url }}</td>
				<td>{{ $data->ip }}</td>
				<td>{{ $data->created_at->diffForHumans() }}</td>
		    </tr>
		    @endforeach
		    </tbody>
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