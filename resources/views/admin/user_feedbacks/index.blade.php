@extends('admin.layouts.admin')

@section('content')

<div class="content-wrapper">
	<div class="mb-4 pb-4 d-flex justify-content-between align-items-center">
	    <h2>用户反馈</h2>
	</div>
	<div class="list table-responsive">
	    <table class="table table-hover">
	        <thead>
		        <tr class="">
		        	<th>@widget('order', ['field' => 'id', 'title'=>'ID'])</th>
					<th>UID</th>
		            <th>联系方式</th>
		            <th>详细描述</th>
					<th>创建时间</th>
		        </tr>
	     	</thead>
		    @foreach ($list as $data)
	        <tr>
				<td>{{ $data->id }}</td>
				<td>{{ $data->user_id }}</td>
				<td>{{ $data->contact }}
				</td>
				<td>{{ $data->description }}
				</td>
				<td>{{ $data->created_at }}</td>
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