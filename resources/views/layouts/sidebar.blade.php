@php
$menuData = [];
array_push($menuData, ['dashboard', 'Dashboard', 'fa-home']);
array_push($menuData, ['production', 'Production', 'fa-briefcase']);
array_push($menuData, ['transfer', 'Transfer', 'fa-archive']);
array_push($menuData, ['receipt', 'Receipt', 'fa-dropbox']);
array_push($menuData, ['search', 'Search', 'fa-search']);
array_push($menuData, ['warehouse', 'Warehouse', 'fa-building']);
array_push($menuData, ['area', 'Area', 'fa-square']);
array_push($menuData, ['line', 'Line', 'fa-exchange']);
array_push($menuData, ['product', 'Product', 'fa-tags']);
array_push($menuData, ['logout', 'Logout', 'fa-sign-out']);
@endphp
<div id="m_aside_left" class="m-grid__item  m-aside-left  m-aside-left--skin-dark ">
    <!-- BEGIN: Aside Menu -->
    <div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark" m-menu-vertical="1" m-menu-scrollable="0" m-menu-dropdown-timeout="500" >
        <ul class="m-menu__nav ">
            @foreach($menuData as $menu)
            <li class="m-menu__item " aria-haspopup="true" >
                <a  href="{{ $menu['0'] }}" class="m-menu__link ">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon fa {{ $menu['2'] }}"></i>
                    <span class="m-menu__link-text">
                        {{ $menu['1'] }}
                    </span>
                </a>
            </li>
            @endforeach
        </ul>
    </div>
    <!-- END: Aside Menu -->
</div>