@extends('layouts.app')
@section('title', '财务明细')
@section('content')
<div class="center container clearfix">
    @include('users.layouts._sidebar')
    <div class="main-container">
        <div class="container-wrapper">
            <div class="header-line d-flex justify-content-between align-items-center border-bottom">
                <div class="tabs clearfix">
                    <a href="{{ route('center.finance.index') }}" class="active">财务明细</a>
                    <a href="{{ route('center.finance.coin') }}">金币明细</a>
                </div>
            </div>
            <div class="">
                <div class="action-controls d-flex justify-content-center align-items-center">
                    <div class="col-md-7">
                        <form name="search" method="get" action="" autocomplete="off">
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
                                    <button class="btn btn-primary" type="submit">搜索</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            <div class="list-wrapper">
            <div class="list table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr class="">
                            <th>项目</th>
                            <th>资金变化</th>
                            <th>余额</th>
                            <th>操作描述</th>
                            <th>@widget('order', ['field' => 'created_at', 'title'=>'时间'])</th>
                        </tr>
                    </thead>
                    @foreach ($list as $data)
                    <tr>
                        <td>{{ $enum_money[$data->enum] }}</td>
                        <td>{{ $data->change }}</td>
                        <td>{{ $data->amount }}</td>
                        <td>{{ $data->description }}</td>
                        <td>{{ $data->created_at->diffForHumans() }}</td>
                    </tr>
                    @endforeach
                </table>
                @if ($list->isEmpty())
                    <div class="no-content">
                        查询不到相关记录
                    </div>
                @endif
                </div></div>
                @if ($list->hasPages())
                    <div class="pagination-wrapper">
                        {{ $list->appends($_GET)->links() }}
                    </div>
                @endif
            </div>
            </div>
        </div>
    </div>
</div>
@stop
