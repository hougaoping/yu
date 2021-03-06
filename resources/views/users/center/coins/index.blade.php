@extends('layouts.app')
@section('title', '购买金币')
@section('content')
<div class="center container clearfix">
    @include('users.layouts._sidebar')
    <div class="main-container">
        <div class="container-wrapper border">
            <div class="header-line p-4 border-bottom">
                <h3>购买金币</h3>
            </div>
            <form action="" method="post" target="" id="form">
    			<div class="list-wrapper p-4">
    				<div class="mb-5 mycoin">
                        <strong class="d-block">您有 <span class="text-red">{{ Auth::user()->coin }}</span> 个金币</strong>
    					购买成功后，将直接转入您的金币账户中
    				</div>
                    <div id="coins" class="coins">
                        <div class="row">
                            <div class="col-md-6 mb-3"><div class="item input_radio"><input name="coins_radio" type="radio" value="20"><strong>20 金币</strong> = ￥{{ 20 + ((float) setting('money_coins_percent')) * 20 }} 元</div></div>
                            <div class="col-md-6 mb-3"><div class="item input_radio"><input name="coins_radio" type="radio" value="50"><strong>50 金币</strong> =￥{{ 50 + ((float) setting('money_coins_percent')) * 50 }} 元</div></div>
                            <div class="col-md-6 mb-3"><div class="item input_radio"><input name="coins_radio" type="radio" value="100"><strong>100 金币</strong> =￥{{ 100 + ((float) setting('money_coins_percent')) * 100 }} 元</div></div>
                            <div class="col-md-6 mb-3"><div class="item input_radio"><input name="coins_radio" type="radio" value="200"><strong>200 金币</strong> =￥{{ 200 + ((float) setting('money_coins_percent')) * 200 }} 元</div></div>
                            <div class="col-md-6 mb-3"><div class="item input_radio"><input name="coins_radio" type="radio" value="500"><strong>500 金币</strong> =￥{{ 500 + ((float) setting('money_coins_percent')) * 500 }} 元</div></div>
                            <div class="col-md-6 mb-3"><div class="item input_radio"><input name="coins_radio" type="radio" value="1000"><strong>1000 金币</strong> =￥{{ 1000 + ((float) setting('money_coins_percent')) * 1000 }} 元</div></div>
                        </div>
                    </div>
                </div>
                <div class="pt-4 pb-4 border-top d-flex justify-content-center align-items-center">
                    <button type="submit" class="btn btn-primary" id="btn-submit">购买金币</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@push('scripts')

$('#btn-submit').click(function(){
	$('#form').ajaxPost();
	return false;
});

@endpush