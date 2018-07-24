<div class="upload-widget">
    <div class="file-box">
        <input class="file-btn fileupload" type="file" name="files[]" multiple="" data-form-data='{"config": "{{ $config }}", "time": @json(time()), "token": @json( md5(time() . 'ad') )}'>
        <div class="progress">
            <div class="progress-bar" style="width: 0%;"></div>
        </div>
    </div>
    <div class="image-list">
        @foreach ($images as $image)
        <div class="image"><span class="remove" data-id="{{ $image->id }}">移除</span>
            <img src="{{ $image->url() }}">
        </div>
        @endforeach
    </div>
    <input type="hidden" class="files" name="{{ $name }}" value="{{ $files }}">
</div>