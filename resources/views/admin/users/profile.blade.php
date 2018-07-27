@extends('admin.layouts.admin')

@section('content')
<div class="content-section">
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
								<select class="form-control address" id="address"><option>请选择</option></select>
							</div>
							<div class="col-4">
								<select class="form-control address" id="city"><option>请选择</option></select>
							</div>
							<div class="col-4">
								<select class="form-control address" id="area"><option>请选择</option></select>
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
</div>
@stop

@push('links')
<script src="{{ asset('js/address.js') }}"></script>
@endpush

@push('scripts')
$(address('<?php echo route('areas')?>', $('.address'), $('#_address')));
@endpush
