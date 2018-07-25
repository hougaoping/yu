<div class="sidebar">
    <div class="menu-list">
        <a class="list-item {{ active_class(if_route('center.profile')) }}" href="{{ route('center.profile') }}">个人信息</a>
        <a class="list-item {{ active_class(if_route('center.password')) }}" href="{{ route('center.password') }}">修改密码</a>
        <a class="list-item {{ active_class(if_route('center.feedback')) }}" href="{{ route('center.feedback') }}">意见反馈</a>
</div>
</div>
