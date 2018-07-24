@extends('admin.layouts.admin')

@section('content')

<div class="content-section">
	<div class="title-section mb-4 border-bottom pb-4 d-flex justify-content-between align-items-center">
	    <h2>广告位列表</h2>
	    <a href="{{ route('admin.ad_positions.create') }}" class="btn btn-primary">添加广告位</a>
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
		            <th>操作</th>
		            <th>广告位名称</th>
		            <th>广告数量</th>
		            <th>状态</th>
		            <th>创建时间</th>
		            <th>更新时间</th>
				</tr>
			</thead>
		    @foreach ($list as $data)
	        </tr>
				<td>{{ $data->id }}</td>
				<td>
					<a class="opt edit" href="{{ route('admin.ad_positions.edit', ['id' => $data['id']]) }}">编辑</a>
		            <span class="opt-separator"> | </span>
		            <form action="{{ route('admin.ad_positions.destroy', $data['id']) }}" method="post" class="inline">
		            	{{ csrf_field() }}
		            	{{ method_field('DELETE') }}
		            	<a class="opt delete submit" href="">删除</a>
		            </form>
				</td>
				<td>
					{{ $data->name }}
				</td>
				<td>
					{{ $data->ads()->count() }}
				</td>
				<td>
					@if ($data->status == 1)
					   启用
					@else
					   禁用
					@endif
				</td>
				<td>{{ $data->created_at }}</td>
				<td>{{ $data->updated_at }}</td>
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