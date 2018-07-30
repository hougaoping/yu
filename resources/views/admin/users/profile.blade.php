@extends('admin.layouts.admin')

@section('content')
<div class="row">
	<div class="col-md-6 col-12">
	<div class="card mb-4">
		<div class="card-header">注册信息</div>
		<div class="show">
			<table class="table table-hover">
				<colgroup>
					<col style="width:30%">
					<col style="width:auto">
				</colgroup>
				<tbody>
				<tr class="">
					<td class="text-right text-muted">电子邮箱：</td>
					<td class="text-md-left">{{ $user['email'] }}</td>
				</tr>
				<tr class="">
					<td class="text-right text-muted">手机号码：</td>
					<td class="text-md-left">{{ $user['mobile'] }}</td>
				</tr>
				<tr class="">
					<td class="text-right text-muted">注册时间：</td>
					<td class="text-md-left">{{ date('Y-m-d H:i:s',$user['register_time']) }}</td>
				</tr>
				<tr class="">
					<td class="text-right text-muted">最后一次登录时间：</td>
					<td class="text-md-left">{{ date('Y-m-d H:i:s',$user['last_login_time']) }}</td>
				</tr>
				<tr class="">
					<td class="text-right text-muted">注册IP地址：</td>
					<td class="text-md-left">{{ $user['register_ip'] }}</td>
				</tr>
				<tr class="">
					<td class="text-right text-muted">最后一次登录IP地址：</td>
					<td class="text-md-left">{{ $user['last_login_ip'] }}</td>
				</tr>
				<tr class="">
					<td class="text-right text-muted">会员类型：</td>
					<td class="text-md-left">{{ $user['type'] == 'seller' ? '商家会员' : '买家会员' }}</td>
				</tr>
				<tr class="">
					<td class="text-right text-muted">登录次数：</td>
					<td class="text-md-left">{{ $user['login_count'] }}</td>
				</tr>
				</tbody>
			</table>
		</div>
	</div>
	</div>
	<div class="col-md-6 col-12">
		<div class="card">
			<div class="card-header">个人信息</div>
			<div class="show">
				<table class="table table-hover">
					<colgroup>
						<col style="width:30%">
						<col style="width:auto">
					</colgroup>
					<tbody>
					<tr class="">
						<td class="text-right text-muted">姓名：</td>
						<td class="text-md-left">{{ $profile['name'] }}</td>
					</tr>
					<tr class="">
						<td class="text-right text-muted">性别：</td>
						<td class="text-md-left">
							<?php
								switch($profile['gender']) {
									case 'male':
										echo '男';
										break;
									case 'female':
										echo '女';
										break;
									default:
										echo '';
										break;
								}
							?>
						</td>
					</tr>
					<tr class="">
						<td class="text-right text-muted">手机号码：</td>
						<td class="text-md-left">{{ $profile['mobile'] }}</td>
					</tr>
					<tr class="">
						<td class="text-right text-muted">电子邮箱：</td>
						<td class="text-md-left">{{ $profile['email'] }}</td>
					</tr>
					<tr class="">
						<td class="text-right text-muted">QQ号码：</td>
						<td class="text-md-left">{{ $profile['qq'] }}</td>
					</tr>
					<tr class="">
						<td class="text-right text-muted">微信号码：</td>
						<td class="text-md-left">{{ $profile['wx'] }}</td>
					</tr>
					<tr class="">
						<td class="text-right text-muted">地址：</td>
						<td class="text-md-left">
							<div class="row">
								<div class="col-4">
									<select class="form-control address disable" id="address" disabled><option>请选择</option></select>
								</div>
								<div class="col-4">
									<select class="form-control address" id="city" disabled><option>请选择</option></select>
								</div>
								<div class="col-4">
									<select class="form-control address" id="area" disabled><option>请选择</option></select>
								</div>
							</div>
							<input type="hidden" name="address" value="@isset($profile['address']){{ $profile['address'] }}@endisset" id="_address">
						</td>
					</tr>
					<tr class="">
						<td class="text-right text-muted">详细地址：</td>
						<td class="text-md-left">{{ $profile['complete_address'] }}</td>
					</tr>
					<tr class="">
						<td class="text-right text-muted">个人简介：</td>
						<td class="text-md-left">{{ $profile['intro'] }}</td>
					</tr>
					</tbody>
				</table>
				</div>
			</div>
		</div>
</div>
@stop

@push('links')
<script src="{{ asset('js/address.js') }}"></script>
@endpush

@push('scripts')
$(address('<?php echo route('areas')?>', $('.address'), $('#_address')));
@endpush
