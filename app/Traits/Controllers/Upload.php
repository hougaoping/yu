<?php
namespace App\Traits\Controllers;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\View;
use App\Upload as UploadClass;

trait Upload
{
    // 文件上传接口
    protected function _upload($config = '', $name = 'files') {
        if(request()->isMethod('POST')) {
            $files = request()->file($name);
            if (!is_array($files)) {
                $files = array($files);
            }

            foreach($files as $file) {
                if($file->isValid()) {
                    $upload = new UploadClass($file, $config);
                    if (!$upload->checkExtension()) {
                        return ['status' => false, 'message' => '不接受的文件类型'];
                    }

                    if (!$upload->checkSize()) {
                        return ['status' => false, 'message' => '不接受的文件大小'];
                    }

                    $fileInfo = $upload->save();
                    return array_merge($fileInfo, ['status'=>true]);
                }
            }
        }

        return ['status' => false, 'message' => '文件上传失败'];
    }
}