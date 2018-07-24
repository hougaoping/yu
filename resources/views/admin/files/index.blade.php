@extends('admin.layouts.admin')

@section('content')

<div class="content-section">
	<div class="title-section mb-5 d-flex justify-content-between align-items-center">
	    <h2>文件列表</h2>
	</div>

	<div class="action-section row mb-4">
		<div class="col-md-5">
		    <form name="search" method="get" action="">
		    	<div class="input-group">
		        	<input name="keywords" type="text" class="search keywords form-control" value="{{ request()->input('keywords') }}" onclick="$(this).focus().select()" placeholder="搜索关键字">
		        	<div class="input-group-append">
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
		            <th>文件名称</th>
		            <th>磁盘</th>
					<th>配置</th>
					<th>文件大小</th>
					<th>文件类型</th>
		            <th>创建时间</th>
		            <th>更新时间</th>
				</tr>
			</thead>
			<tbody>
		    @foreach ($list as $data)
	        </tr>
				<td>{{ $data->id }}</td>
				<td>
					<a href="{{ $data->url() }}" name="imageurl"></a>
					{{ $data->name }}
				</td>
				<td>{{ $data->disk }}</td>
				<td>{{ $data->config }}</td>
				<td>{{ get_real_size($data->size) }}</td>
				<td>{{ $data->mimes }}</td>
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
	    <div class="pagination-wrapper">
            {{ $list->appends($_GET)->links() }}
        </div>
	@endif
</div>
@stop

@push('scripts')

$(function (){
    var box;
    function createBox(){
        if (!box) {
            box = $('<div></div>');
            box.css({
                position: 'absolute',
                width: 180,
                height: 'auto',
                border: '1px solid #ddd',
                padding: 5,
                background: '#fff',
                overflow: 'hidden',
                boxShadow: "rgba(111, 111, 111, 0.498039) 2px 2px 5px"
            });
            box.appendTo(document.body);
        }
    }
    $('.list').on('mouseenter', 'tr', function () {

    	// if($(this).index() == 0) return; // 排除标题行

    	var href = $('a[name=imageurl]', this).attr('href');
    	if (!href) {
    		return;
    	}

    	createBox();
		// 扩展名为图片才显示预览
        var suffix = href.substring(href.lastIndexOf('.')+1, href.length).toLowerCase();
        if (($.inArray(suffix, ['', 'gif','png','jpeg', 'bmp', 'jpg']))) {
            box.html('<img src="'+href+'" style="1px solid #eee;width:100%">');
            box.css({
                top: $(this).offset().top - 5,
                right: 0
            });
            box.stop().fadeIn();
        }
        
    }).on('mouseleave', 'tr', function (){
         createBox();
         box.stop().fadeOut();
    })
})

@endpush