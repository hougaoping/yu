@extends('admin.layouts.admin')

@section('content')

<div class="content-wrapper">
	<div class="mb-4 pb-4 d-flex justify-content-between align-items-center">
	    <h2>链接列表</h2>
	    <a href="{{ route('admin.links.create') }}" class="btn btn-primary">添加链接</a>
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
	<div class="list table-responsive">
		<table class="table table-hover">
	        <thead>
		        <tr class="">
		        	<th>@widget('Order', ['field' => 'id', 'title'=>'ID'])</th>
		            <th>操作</th>
		            <th>站点名称</th>
		            <th>分类关键字</th>
		            <th>状态</th>
		            <th>创建时间</th>
		            <th>更新时间</th>
				</tr>
			</thead>
			<tbody>
		    @foreach ($list as $data)
	        <tr>
				<td>{{ $data->id }}</td>
				<td>
					<a class="opt edit" href="{{ route('admin.links.edit', ['id' => $data['id']]) }}">编辑</a>
		            <span class="split"> | </span>
		            <form action="{{ route('admin.links.destroy', $data['id']) }}" method="post" class="inline">
		            	{{ csrf_field() }}
		            	{{ method_field('DELETE') }}
		            	<a class="opt delete submit" href="">删除</a>
		            </form>
				</td>
				<td>
					<span class="subject">{{ $data->name }}</span>
					{{ $data->url }}
				</td>
				<td>{{ $data->category }}</td>
				<td>
					@if ($data->status == 1)
					  启用
					@else
					  禁用
					@endif
				</td>
				<td>{{ $data->created_at->diffForHumans() }}</td>
				<td>{{ $data->updated_at->diffForHumans() }}</td>
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
	    <div class="pt-4 border-top d-flex justify-content-end align-items-center">
            {{ $list->appends($_GET)->links() }}
        </div>
	@endif
</div>
@stop
