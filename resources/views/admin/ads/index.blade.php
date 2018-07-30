@extends('admin.layouts.admin')

@section('content')
<div class="content-wrapper">
	<div class="mb-4 pb-4 d-flex justify-content-between align-items-center">
	    <h2>广告列表</h2>
	    <a href="{{ route('admin.ads.create') }}" class="btn btn-primary">添加广告</a>
	</div>

	<div class="row">
		<div class="col-md-5 mb-4">
		    <form name="search" method="get" action="">
		    	<div class="input-group">
			        	<input name="keywords" type="text" class="search keywords form-control" value="{{ request()->input('keywords') }}" onclick="$(this).focus().select()" placeholder="搜索关键字">
			        	
		        	<div class="input-group-append">
		        		<select name="ad_position_id" class="form-control">
				                <option value="">请选择广告</option>
				                @foreach ($positions as $id => $name)
				                	<option value="{{ $id }}" @if(request()->has('ad_position_id') && $id == request()->input('ad_position_id')) selected="selected" @endif>{{ $name }}</option>
			                	@endforeach
		            	</select>
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
		            <th>广告名称</th>
					<th>所属广告位</th>
		            <th>广告排序</th>
		            <th>状态</th>
		            <th>创建时间</th>
				</tr>
			</thead>
		    @foreach ($list as $data)
	        <tr>
				<td>{{ $data->id }}</td>
				<td>
					<a class="opt edit" href="{{ route('admin.ads.edit', ['id' => $data['id']]) }}">编辑</a>
		            <span class="opt-separator"> | </span>
		            <form class="inline" action="{{ route('admin.ads.destroy', $data['id']) }}" method="post">
		            	{{ csrf_field() }}
		            	{{ method_field('DELETE') }}
		            	<a class="opt delete submit" href="">删除</a>
		            </form>
				</td>
				<td>
					{{ $data->name }}
				</td>
				<td>
					{{ $data->position->name }}
				</td>
				<td>{{ $data->order }}</td>
				<td>
					@if ($data->status == 1)
						启用
					@else
						禁用
					@endif
				</td>
				<td>{{ $data->created_at}}</td>
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