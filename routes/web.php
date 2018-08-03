<?php

// 网站首页
Route::get('/', function() {
    return Redirect::to(route('signin.mobile'));
})->name('index');

Route::match(['get'], 'areas/index', 'AreaController@index')->name('areas');

Route::match(['get', 'post'], 'signup', 'Users\IndexController@register')->name('signup');
Route::match(['get','post'], 'signin', 'Users\IndexController@login')->name('signin');
Route::get('signup/confirm', 'Users\IndexController@confirmEmail')->name('signup.confirm');

Route::match(['get', 'post'], 'signup/mobile', 'Users\Mobile\IndexController@register')->name('signup.mobile');
Route::match(['get','post'], 'signin/mobile', 'Users\Mobile\IndexController@login')->name('signin.mobile');
Route::post('signup/mobile/verify', 'Users\Mobile\IndexController@verify')->middleware('throttle:3')->name('signup.mobile.verify');

Route::get('login', function() {
    return Redirect::to(route('signup.mobile'));
})->name('login');

Route::get('logout', 'Users\IndexController@logout')->name('logout');

// 找回密码
Route::group(['prefix' => 'forgot', 'namespace' => 'Users'], function() {
    Route::match(['get','post'], '/', 'ForgotController@index')->name('forgot');
    route::match(['get','post'], 'reset', 'ForgotController@reset')->name('forgot.reset');
    Route::match(['get','post'], 'mobile', 'Mobile\ForgotController@index')->name('forgot.mobile');
    route::match(['get','post'], 'mobile/reset', 'Mobile\ForgotController@reset')->name('forgot.mobile.reset');
});

// 会员中心路由
Route::name('center.')->group(function () {
    Route::group(['prefix' => 'center', 'namespace' => 'Users\Center'], function() {
        Route::match(['get', 'post'], 'password', 'PassswordController@index')->name('password.index');
        Route::match(['get', 'post'], 'safe_password', 'SafePassswordController@index')->name('password.safe_password');
        Route::match(['get'], 'finances', 'FinancesController@index')->name('finances.index');
        Route::match(['get'], 'finances/export', 'FinancesController@export')->name('finances.export');
        Route::match(['get'], 'finances/coins', 'FinancesController@coins')->name('finances.coins');
        Route::match(['get'], 'finances/coins/export', 'FinancesController@coinsExport')->name('finances.coins.export');
        Route::match(['get', 'post'], 'coins', 'CoinsController@index')->name('coins.index');
        Route::match(['get', 'post'], 'feedback', 'FeedbackController@index')->name('feedback.index');
        Route::match(['get', 'post'], 'profile', 'ProfileController@index')->name('profile.index');
        Route::match(['get'], '/', function() {
            return redirect()->route('center.profile.index');
        })->name('index');
    });
});

Route::name('article.')->group(function() {
    Route::group(['prefix' => 'articles'], function() {
        Route::match(['get'], 'category/{category?}', 'Articles\IndexController@category')->where('article', '[0-9]+')->name('category');
        Route::match(['get'], '/{article}', 'Articles\IndexController@index')->where('article', '[0-9]+')->name('index');
    });
});

// 后台模块路由
Route::name('admin.')->group(function () {
    Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'auth'], function() {
        Route::match(['post'], '/upload', 'UploadController@index')->name('upload');
        Route::match(['post'], '/upload/tinymce', 'UploadController@tinymce')->name('upload.tinymce');
        Route::match(['get', 'post'], '/login', 'IndexController@index')->name('index');
        Route::match(['get'], '/dashboard', 'DashboardController@index')->name('dashboard');
        Route::match(['get', 'post'], '/settings', 'SettingsController@index')->name('settings');
        Route::resource('links', 'LinksController', ['except'=>['show']]);
        Route::resource('files', 'FilesController', ['only'=>['index']]);
        Route::resource('ad_positions', 'AdPositionsController', ['except'=>['show']]);
        Route::resource('ads', 'AdsController', ['except'=>['show']]);
        Route::resource('article_categories', 'ArticleCategoriesController', ['except'=>['show']]);
        Route::resource('articles', 'ArticlesController', ['except'=>['show']]);
        Route::resource('user_loginlogs', 'UserLoginlogsController', ['only'=>['index']]);
        Route::resource('activity_logs', 'ActivityLogsController', ['only'=>['index']]);
        Route::resource('users', 'UsersController', ['only'=>['index', 'destroy']]);
        Route::match(['get'], 'users/{user}/profile', 'UsersController@profile')->name('users.profile');
        Route::match(['get','post'], 'users/{user}/charge', 'UsersController@charge')->name('users.charge');
        Route::resource('user_emails', 'UserEmailsController', ['only'=>['index']]);
        Route::resource('user_finances', 'UserFinancesController', ['only'=>['index']]);
        Route::resource('user_coins', 'UserCoinsController', ['only'=>['index']]);
        Route::resource('user_feedbacks', 'UserFeedbacksController', ['only'=>['index']]);
        Route::resource('admin', 'AdminController', ['except'=>['show']]);
        Route::resource('roles', 'RolesController', ['except'=>['show']]);
    });
});
