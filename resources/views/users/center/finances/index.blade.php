@extends('layouts.app')
@section('title', '财务明细')
@section('content')
<div class="center container clearfix">
    @include('users.layouts._sidebar')
    <div class="main-container">
        <div class="container-wrapper border">
            <div class="header-line d-flex justify-content-between align-items-center border-bottom">
                <div class="tabs clearfix">
                    <a href="{{ route('center.finances.index') }}" class="active">财务明细</a>
                    <a href="{{ route('center.finances.coins') }}">金币明细</a>
                </div>
            </div>
            <div class="list-wrapper">
                <div class="row pt-5 pb-5 d-flex justify-content-start align-items-center">
                    <div class="col-md-7">
                        <form name="search" method="get" action="" autocomplete="off" id="filter-form">
                            <div class="input-group">
                                <input name="start_time" type="text" class="search date-picker form-control" value="{{ request()->input('start_time') }}" placeholder="起始时间">
                                <input name="end_time" type="text" class="search date-picker form-control" value="{{ request()->input('end_time') }}" placeholder="结束时间">
                                <div class="input-group-append">
                                    <select name="enum" class="form-control">
                                        <option value="">请选择项目</option>
                                        @foreach ($enum_money as $key => $name)
                                        <option value="{{ $key }}" @if(request()->has('enum') && $key == request()->input('enum')) selected="selected" @endif>{{ $name }}</option>
                                        @endforeach
                                    </select>
                                    <button class="btn btn-primary" type="submit">查询</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col mt-3 mt-md-0"><a class="btn btn-primary export" href="<?php echo route('center.finances.export') ?>" id="export">导出数据</a></div>
                </div>
            
            <div class="list table-responsive">
                <table class="table table-hover">
                    <thead class="">
                        <tr class="">
							<th>@widget('order', ['field' => 'created_at', 'title'=>'时间'])</th>
                            <th>项目</th>
                            <th class="text-left">资金变化</th>
                            <th class="text-left">余额</th>
                        </tr>
                    </thead>
                    @foreach ($list as $data)
                    <tr>
						<td>{{ $data->created_at->diffForHumans() }}</td>
                        <td>{{ $data->type }}</td>
                        <td class="text-success text-left">{{ $data->change }}</td>
                        <td class="text-danger text-left">{{ $data->amount }}</td>
                    </tr>
                    @endforeach
                </table>
                @if ($list->isEmpty())
                    <div class="no-content">
                        查询不到相关记录
                    </div>
                @endif
            </div>
		</div>
		@if ($list->hasPages())
			<div class="pagination-wrapper">
				{{ $list->appends($_GET)->links() }}
			</div>
		@endif
        </div>
    </div>
</div>
@stop
