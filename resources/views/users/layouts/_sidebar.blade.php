<div class="sidebar">
    <div class="menu-list">
        <a class="list-item {{ active_class(if_route_pattern('center.finances.*')) }}" href="{{ route('center.finances.index') }}">财务明细</a>
        <a class="list-item {{ active_class(if_route_pattern('center.coins.*')) }}" href="{{ route('center.coins.index') }}">购买金币</a>
        <a class="list-item {{ active_class(if_route_pattern('center.profile.*')) }}" href="{{ route('center.profile.index') }}">个人信息</a>
        <a class="list-item {{ active_class(if_route_pattern('center.password.*')) }}" href="{{ route('center.password.index') }}">修改密码</a>
        <a class="list-item {{ active_class(if_route_pattern('center.feedback.*')) }}" href="{{ route('center.feedback.index') }}">意见反馈</a>
    </div>
</div>
