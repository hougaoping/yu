@extends('admin.layouts.admin')

@section('content')

<div class="content-section">
	<div class="title-section mb-5 d-flex justify-content-between align-items-center">
	    <h2>用户邮箱</h2>
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
		        	<th>@widget('order', ['field' => 'id', 'title'=>'ID'])</th>
					<th>UID</th>
		            <th>邮箱地址</th>
		            <th>邮箱是否验证</th>
					<th>创建时间</th>
					<th>更新时间</th>
		        </tr>
	     	</thead>
		    @foreach ($list as $data)
	        </tr>
				<td>{{ $data->user_id }}</td>
				<td>{{ $data->id }}</td>
				<td>
					{{ $data->email }}
				</td>
				<td>
					@if ($data->activated == 1)
					  已验证
					@else
					  未验证
					@endif
				</td>
				<td>{{ $data->created_at }}</td>
				<td>{{ $data->updated_at }}</td>
		    </tr>
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