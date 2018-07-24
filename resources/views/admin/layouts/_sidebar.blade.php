<div class="sidebar">
    <div class="logo">
        {{ setting('name') }}平台管理
    </div>
    <div class="menus">

        <?php
            $sidebar = sidebar($sidebar);
        ?>

    	@foreach ($sidebar as $menu)
        @if(isset($menu['permission']) && $menu['permission'])
            <div class="menu">
                <div class="menu-headline {!! isset($menu['is_active']) ? 'current':'' !!}">
                    <i></i>
                    <span>{{ $menu['name'] }}</span>
                </div>
        		<ul class="menu-body" {!! isset($menu['is_active']) ? 'style="display:block"':'' !!}>
        			@foreach ($menu['items'] as $item)
                    @if(isset($item['permission']) && $item['permission'])
        			<li class="{{ isset($item['is_active']) ? 'active' : '' }}"><a href="<?php echo !empty($item['route']) ? route($item['route']) : '' ?>">{{ $item['title'] }}</a></li>
        			@endif
                    @endforeach
        		</ul>
            </div>
        @endif
    	@endforeach
    </div>
</div>