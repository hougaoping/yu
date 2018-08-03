@extends('admin.layouts.admin')

@section('content')

<div class="content-wrapper">
	<div class="mb-4 pb-4 d-flex justify-content-between align-items-center">
	    <h2>文章分类</h2>
	    <a href="{{ route('admin.article_categories.create') }}" class="btn btn-primary">添加文章分类</a>
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
		        	<th>ID</th>
		            <th>操作</th>
		            <th>分类名称</th>
		            <th>文章数量</th>
		            <th>创建时间</th>
		            <th>更新时间</th>
				</tr>
			</thead>
		    @foreach ($tree as $category)
	        <tr>
	        	<td>{{ $category['id']}}</td>
				<td>
					<a class="opt edit" href="{{ route('admin.article_categories.edit', ['id' => $category['id']]) }}">编辑</a>
		            <span class="split"> | </span>
		            <form action="{{ route('admin.article_categories.destroy', $category['id']) }}" method="post" class="inline">
		            	{{ csrf_field() }}
		            	{{ method_field('DELETE') }}
		            	<a class="opt delete submit" href="">删除</a>
		            </form>
				</td>
				<td>
					{!! str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;", $category['level']) !!} {{ $category['item']->name }}
				</td>
				<td>{{ $category['item']->articles->count() }}</td>
				<td>{{ $category['item']->created_at }}</td>
				<td>{{ $category['item']->updated_at }}</td>
		    </tr>
		    @endforeach
	    </table>
	    @if (empty($tree))
		    <div class="no-content">
	            查询不到相关记录
	        </div>
        @endif
	</div>
</div>
@stop
