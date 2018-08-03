@extends('admin.layouts.admin')

@section('content')

<div class="content-wrapper">
	<div class="mb-5 d-flex justify-content-between align-items-center">
	    <h2>角色列表</h2>
	    <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">添加角色</a>
	</div>
	<div class="list table-responsive">
		<table class="table table-hover">
	        <thead>
		        <tr class="">
		        	<th>@widget('Order', ['field' => 'id', 'title'=>'ID'])</th>
		            <th>操作</th>
		            <th>角色名称</th>
		            <th>创建时间</th>
		            <th>更新时间</th>
				</tr>
			</thead>
			<tbody>
		    @foreach ($roles as $role)
	        <tr>
				<td>{{ $role->id }}</td>
				<td>
					<a class="opt edit" href="{{ route('admin.roles.edit', ['id' => $role['id']]) }}">编辑</a>
		            <span class="split"> | </span>
		            <form action="{{ route('admin.roles.destroy', $role['id']) }}" method="post" class="inline">
		            	{{ csrf_field() }}
		            	{{ method_field('DELETE') }}
		            	<a class="opt delete submit" href="">删除</a>
		            </form>
				</td>
				<td>
					{{ $role->name }}
				</td>
				<td>{{ $role->created_at->diffForHumans() }}</td>
				<td>{{ $role->updated_at->diffForHumans() }}</td>
		    </tr>
		    @endforeach
		    </tbody>
	    </table>
	    @if ($roles->isEmpty())
		    <div class="no-content">
	            查询不到相关记录
	        </div>
        @endif
	</div>
</div>
@stop
