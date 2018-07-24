<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use App\Models\UserProfile;
use App\Observers\UserProfileObserver;
use App\Models\UserFeedback;
use App\Observers\UserFeedbackObserver;
use \Illuminate\Pagination\LengthAwarePaginator;
use \Illuminate\Support\Facades\Validator;


class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Carbon::setLocale('zh');
        UserProfile::observe(UserProfileObserver::class);
		UserFeedback::observe(UserFeedbackObserver::class);
        // LengthAwarePaginator::defaultView('pagination::default');

        Validator::extend('mobile', function ($attribute, $value, $parameters, $validator) {
            if(!preg_match("/^1[34578]\d{9}$/", $value))
                return false;
            return true;
        });

        Validator::replacer('mobile', function ($message, $attribute, $rule, $parameters) {
            return '请输入正确的手机号码';
        });
    }

    public function register()
    {
    }
}
