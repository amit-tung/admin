
@php
    $menus = [
        [
            'name'=>"Festival",
            'url'=>"festival",
            'iconClass'=>"fas fa-circle nav-icon",
            'menu'=>
            [
                [
                    'name'=>"Ds",
                    'url'=>"dashboard",
                    'iconClass'=>"fas fa-circle nav-icon"
                ],
            ],
        ],
        [
            'name'=>"Users",
            'url'=>"users",
            'iconClass'=>"fas fa-circle nav-icon",
            
        ],
    ]
        
@endphp 






<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link">
        <img src="{{asset('/adminpanel/images/banner_logo.jpg')}}" alt="Logo image"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Digital PosterHUB </span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                @foreach ($menus as $item)
                    <li class="nav-item">
                        <a href="{{ url("adminpanel/".$item['url'])}}" class="nav-link {{ isset($item['menu'])&&array_search(explode('adminpanel/',request()->path())[1],array_column($item['menu'],'url'))!==FALSE?'active':'' }}">
                            <i class="{{$item['iconClass']}}"></i>
                            <p> {{ $item['name'] }}
                                @if (isset($item['menu']))
                                    <i class="right fas fa-angle-left"></i>
                                @endif
                            </p>
                        </a>
                        @if (isset($item['menu']))
                            <ul class="nav nav-treeview" style="display: none;">
                                @foreach ($item['menu'] as $subItem)
                                    <li class="nav-item">
                                        <a href="{{ url("adminpanel/".$subItem['url'])}}"
                                            class="nav-link ">
                                            <i class="{{$item['iconClass']}}"></i>
                                            <p>{{$subItem['name']}}</p>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach

                <li class="nav-item ">
                    <a href="{{route('logout')}}" class="nav-link text-danger">
                        <i class="fas fa-sign-out-alt nav-icon"></i>
                        <p>Logout</p>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
