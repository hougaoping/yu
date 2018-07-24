<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Exceptions\HttpResponseException;
use \App\Traits\Controllers\Jump as JumpTrait;
use Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, JumpTrait;

    // 使用PHPmailer发送邮件
    protected function sendEmail($view, $data, $to = '', $subject, $cc = [], $bcc = []) {
        email($to, $subject, view($view, $data), $cc, $bcc);
    }

    protected function _order($order = 'id-desc') {
        if (request()->has('order')) {
            return request()->order;
        }
        return $order;
    }

    protected function _rows() {
        return request()->has('rows') ? (int) request()->input('rows') : 15;
    }

    public function _logout() {
        Auth::check() && Auth::logout();
        session()->exists('is_admin') && session()->forget('is_admin');
        session()->forget('last_login_time');
        session()->forget('username');
        session()->flash('success', '您已成功退出');
        return redirect('login');
    }

}
