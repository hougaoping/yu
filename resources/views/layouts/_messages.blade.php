@foreach (['info', 'success', 'warning', 'danger'] as $msg)
    @if(session()->has($msg))
    <div class="alert alert-dismissable alert-{{$msg}}">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session()->get($msg) }}
    </div>
    @endif
@endforeach