@extends('admin.layouts.admin')

@section('content')

<div class="content-wrapper">
	<div class="pb-4 mb-4">
	    <h3>平台操作日志</h3>
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
		            <th>Description</th>
		            <th>Subject type</th>
					<th>Subject id</th>
					<th>Causer type</th>
					<th>Causer id</th>
		            <th>Create time</th>
				</tr>
			</thead>
			<tbody>
		    @foreach ($list as $data)
	        <tr>
				<td>{{ $data->id }}</td>
				<td>{{ $data->description }}</td>
				<td>{{ $data->subject_type }}</td>
				<td>{{ $data->subject_id }}</td>
				<td>{{ $data->causer_type }}</td>
				<td>{{ $data->causer_id }}</td>
				<td>{{ $data->created_at }}</td>
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
