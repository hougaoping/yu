<nav class="header">
	@component('components.logo')
	<a class="brand" href="/" title="{{ setting('name') }}">
		<img src="/images/logo.png" class="logo">
	</a>
	@endcomponent
	<div class="login-navbar">
		@guest
		<a class="navbar-item" href="{{ route('signin.mobile') }}">登录</a>
		<a class="navbar-item" href="{{ route('signup.mobile') }}">注册</a>
		@else
	 	<div class="drop-menu">
		    <a class="navbar-item" href="javascript:void(0);">{{ session('username') }} </a>
		    	<div class="menu-content">
			    	@can('admin', Auth::user())
			    	<a class="navbar-item menu-item" href="{{ route('admin.index') }}" target="_blank">管理中心</a>
			    	@endcan
					<a class="navbar-item menu-item" href="{{ route('center.index') }}">会员中心</a>
					<a class="navbar-item menu-item" href="{{ route('logout') }}">退出</a>
		    	</div>
	  	</div>
		@endguest
	</div>
</nav>
