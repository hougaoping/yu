<div class="header d-flex justify-content-between align-items-center"">
    <span id="expand-sidebar" title="折叠菜单"></span>
    <div class="header-nav dropdown">
        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
          {{ Auth::user()->getUsername(false)}}
        </button>
        <div class="dropdown-menu">
          <?php
            $roles = Auth::user()->getAdminRolesName();
            isset($roles[0]) ? '<a class="dropdown-item disabled" href="">' . $roles[0] . '</a>' : '';
          ?>
          <a class="dropdown-item" href="{{ route('center.password') }}" target="_blank">修改我的密码</a>
          <a class="dropdown-item" href="{{ route('logout') }}">退出</a>
        </div>
    </div>
</div>