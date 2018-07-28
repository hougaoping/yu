@extends('admin.layouts.admin')

@section('content')

<div class="content-section">
	<div class="title-section mb-4 pb-4 d-flex justify-content-between align-items-center">
	    <h2>财务明细</h2>
	</div>
	<div class="action-section row mb-4">
		<div class="col-md-5">
		    <form name="search" method="get" action="">
		    	<div class="input-group">
		        	<input name="uid" type="text" class="search keywords form-control" value="{{ request()->input('uid') }}" onclick="$(this).focus().select()" placeholder="UID">
		        	<div class="input-group-append">
			        	<select name="enum" class="form-control">
			                <option value="">请选择项目</option>
			                @foreach ($enum_money as $key => $name)
			                <option value="{{ $key }}" @if(request()->has('enum') && $key == request()->input('enum')) selected="selected" @endif>{{ $name }}</option>
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
					<th>UID</th>
					<th>项目</th>
					<th>资金变化</th>
					<th>余额</th>
					<th>操作描述</th>
					<th>创建时间</th>
		        </tr>
	     	</thead>
		    @foreach ($list as $data)
	        </tr>
				<td>{{ $data->id }}</td>
				<td>{{ $data->user_id }}</td>
				<td>{{ $enum_money[$data->enum] }}</td>
				<td>{{ $data->change }}</td>
				<td>{{ $data->amount }}</td>
				<td class="text-muted">{{ $data->description }}</td>
				<td>{{ $data->created_at }}</td>
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