<?php
namespace App\Traits\Controllers;
use Illuminate\Http\Exceptions\HttpResponseException;

trait Jump
{
	protected function _dispatch_success_tmpl() {

        if (request()->is('admin/*')) {
            return 'admin.jumps.cpmsg';
        }

        return 'jumps.dispatch_jump';
    }

    protected function _dispatch_error_tmpl() {

        if (request()->is('admin/*')) {
            return 'admin.jumps.cpmsg';
        }

        return 'jumps.dispatch_jump';
    }

    protected function success($message = '', $url = null, $data = '', $wait = 3, array $header = []) {

        if (is_null($url)) {
            $url = url()->previous();
        }

        $result = [
            'message'  => $message,
            'data'     => $data,
            'url'      => $url,
            'wait'     => $wait,
            'code'     => 1,
        ];

        if(request()->ajax()) {
            $response = response()->json($result, 200)->withHeaders($header);
        } else {
            $response = response()->view($this->_dispatch_success_tmpl(), $result)->withHeaders($header);
        }
        
        throw new HttpResponseException($response);
    }

    protected function error($message = '', $url = null, $data = '', $wait = 5, array $header = []) {

        if (is_null($url)) {
            $url = request()->ajax() ? '' : 'javascript:history.back(-1);';
        }

        $result = [
            'message'  => $message,
            'data'     => $data,
            'url'      => $url,
            'wait'     => $wait,
            'code'     => 0,
        ];

        if(request()->ajax()) {
            $response = response()->json($result, 422)->withHeaders($header);
        } else {
            $response = response()->view($this->_dispatch_error_tmpl(), $result)->withHeaders($header);
        }

        throw new HttpResponseException($response);
    }
}