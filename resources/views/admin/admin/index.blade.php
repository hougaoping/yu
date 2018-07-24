@extends('admin.layouts.admin')

@section('content')

<div class="content-section">
	<div class="title-section mb-5 d-flex justify-content-between align-items-center">
	    <h2>管理员列表</h2>
	    <a href="{{ route('admin.admin.create') }}" class="btn btn-primary">添加管理员</a>
	</div>
	
	<div class="list table-responsive">
		<table class="table table-hover">
	        <thead>
		        <tr class="">
		        	<th>@widget('order', ['field' => 'id', 'title'=>'ID'])</th>
		            <th>操作</th>
		            <th>电子邮箱</th>
		            <th>所属角色</th>
		            <th>创建时间</th>
		            <th>更新时间</th>
				</tr>
			</thead>
			<tbody>
		    @foreach ($list as $data)
	        </tr>
				<td>{{ $data->id }}</td>
				<td>
					<a class="opt edit" href="{{ route('admin.admin.edit', ['id' => $data->id]) }}">编辑</a>
		            <span class="opt-separator"> | </span>
		            <form action="{{ route('admin.admin.destroy', $data->id) }}" method="post" class="inline">
		            	{{ csrf_field() }}
		            	{{ method_field('DELETE') }}
		            	<a class="opt delete submit" href="">删除</a>
		            </form>
				</td>
				<td>
					{{ $data->email }}
				</td>
				<td>
					<?php echo implode(', ', $data->getAdminRolesName())?>
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
</div>
@stop
