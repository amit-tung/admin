<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <li class="nav-item">
        <a href="{{ url('admin/home') }}" class="nav-link {{ !empty($menu) && $menu=="home"?"active":"" }}">
            <i class="fas fa-circle nav-icon"></i>
            <p>Dashboard</p>
        </a>
    </li>

    <li class="nav-item {{ !empty($menu) && $menu=="festival"?"menu-open ":"" }}">
        <a href="#" class="nav-link {{ !empty($menu) && $menu=="festival"?"active":"" }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
                Festival
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview" style="display: {{ !empty($menu) && $menu=="festival"?"block ":"none" }};">
            <li class="nav-item">
                <a href="{{ url('admin/festival-category') }}" class="nav-link {{ !empty($submenu) && $submenu=="festival-category"?"active":"" }}">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>Festival Category</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('admin/festival-sub-category') }}" class="nav-link {{ !empty($submenu) && $submenu=="festival-sub-category"?"active":"" }}">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>Festival Sub Category</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('admin/festival-peta-category') }}" class="nav-link {{ !empty($submenu) && $submenu=="festival-peta-category"?"active":"" }}">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>Festival Peta Category</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('admin/festival-post') }}" class="nav-link {{ !empty($submenu) && $submenu=="festival-post"?"active":"" }}">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>Festival Post </p>
                </a>
            </li>
        </ul>
    </li>

{{-- 
    <li class="nav-item {{ !empty($menu) && $menu=="dharma"?"menu-open ":"" }}">
        <a href="#" class="nav-link {{ !empty($menu) && $menu=="dharma"?"active":"" }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
                Dharma
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview" style="display: {{ !empty($menu) && $menu=="dharma"?"block ":"none" }};">
            <li class="nav-item">
                <a href="{{ url('admin/dharma_image_category') }}" class="nav-link {{ !empty($submenu) && $submenu=="dharma_image_category"?"active":"" }}">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>Dharma Image Category</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('admin/dharma_image') }}" class="nav-link {{ !empty($submenu) && $submenu=="dharma_image"?"active":"" }}">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>Dharma Image </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('admin/dharma_video_category') }}" class="nav-link {{ !empty($submenu) && $submenu=="dharma_video_category"?"active":"" }}">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>Dharma Video Category</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('admin/dharma_video') }}" class="nav-link {{ !empty($submenu) && $submenu=="dharma_video"?"active":"" }}">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>Dharma Video </p>
                </a>
            </li>

        </ul>
    </li>
   

    <li class="nav-item {{ !empty($menu) && $menu=="video"?"menu-open ":"" }}">
        <a href="#" class="nav-link {{ !empty($menu) && $menu=="video"?"active":"" }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
                Video
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview" style="display: {{ !empty($menu) && $menu=="video"?"block ":"none" }};">
            <li class="nav-item">
                <a href="{{ url('admin/video_category') }}" class="nav-link {{ !empty($menu) && $menu=="video_category"?"active":"" }}">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>Video Category</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('admin/video_upload') }}" class="nav-link {{ !empty($menu) && $menu=="video_upload"?"active":"" }}">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>Video Upload</p>
                </a>
            </li>
        </ul>
    </li>--}}

    <li class="nav-item {{ !empty($menu) && $menu=="business"?"menu-open ":"" }}">
        <a href="#" class="nav-link {{ !empty($menu) && $menu=="business"?"active":"" }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
                Business
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview" style="display: {{ !empty($menu) && $menu=="business"?"block ":"none" }};">
            <li class="nav-item">
                <a href="{{ url('admin/business-category') }}" class="nav-link {{ !empty($submenu) && $submenu=="business-category"?"active":"" }}">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>Business Category</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('admin/business-sub-category') }}" class="nav-link {{ !empty($submenu) && $submenu=="business-sub-category"?"active":"" }}">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>Business Sub Category</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('admin/business-post') }}" class="nav-link {{ !empty($submenu) && $submenu=="business-post"?"active":"" }}">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>Business Post</p>
                </a>
            </li>
        </ul>
    </li>
    {{--
    <li class="nav-item {{ !empty($menu) && $menu=="general"?"menu-open ":"" }}">
        <a href="#" class="nav-link {{ !empty($menu) && $menu=="general"?"active":"" }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
                General Category
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview" style="display: {{ !empty($menu) && $menu=="general"?"block ":"none" }};">
            <li class="nav-item">
                <a href="{{ url('admin/general_image_category') }}" class="nav-link {{ !empty($submenu) && $submenu=="general_image_category"?"active":"" }}">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>General Image Category</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('admin/general_image') }}" class="nav-link {{ !empty($submenu) && $submenu=="general_image"?"active":"" }}">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>General Image</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('admin/general_video_category') }}" class="nav-link {{ !empty($submenu) && $submenu=="general_video_category"?"active":"" }}">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>General Video Category</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('admin/general_video') }}" class="nav-link {{ !empty($submenu) && $submenu=="general_video"?"active":"" }}">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>General Video</p>
                </a>
            </li>
        </ul>
    </li>

    <li class="nav-item">
        <a href="{{ url('admin/banner_upload') }}" class="nav-link {{ !empty($menu) && $menu=="banner_upload"?"active":"" }}">
            <i class="fas fa-circle nav-icon"></i>
            <p>Banner Upload</p>
        </a>
    </li>

    <li class="nav-item {{ !empty($menu) && $menu=="greeting"?"menu-open ":"" }}">
        <a href="#" class="nav-link {{ !empty($menu) && $menu=="greeting"?"active":"" }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
                Greeting
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview" style="display: {{ !empty($menu) && $menu=="greeting"?"block ":"none" }};">
            <li class="nav-item">
                <a href="{{ url('admin/greeting_category') }}" class="nav-link {{ !empty($submenu) && $submenu=="greeting_category"?"active":"" }}">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>Greeting Category</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('admin/greeting_image') }}" class="nav-link {{ !empty($submenu) && $submenu=="greeting_image"?"active":"" }}">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>Greeting Image</p>
                </a>
            </li>

        </ul>
    </li> --}}


{{-- 
    <li class="nav-item">
        <a href="{{ url('admin/slider') }}" class="nav-link  {{ !empty($menu) && $menu=="slider"?"active":"" }}">
            <i class="fas fa-circle nav-icon"></i>
            <p>Banner Upload</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ url('admin/business') }}" class="nav-link  {{ !empty($menu) && $menu=="business"?"active":"" }}">
            <i class="fas fa-circle nav-icon"></i>
            <p>Business list</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ url('admin/feedback') }}" class="nav-link  {{ !empty($menu) && $menu=="feedback"?"active":"" }}">
            <i class="fas fa-circle nav-icon"></i>
            <p>Feedback</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ url('admin/pages') }}" class="nav-link  {{ !empty($menu) && $menu=="pages"?"active":"" }}">
            <i class="fas fa-circle nav-icon"></i>
            <p>Pages</p>
        </a>
    </li> --}}
    <li class="nav-item">
        <a href="{{ url('admin/user') }}" class="nav-link  {{ !empty($menu) && $menu=="user"?"active":"" }}">
            <i class="fas fa-circle nav-icon"></i>
            <p>User</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ url('admin/apps') }}" class="nav-link  {{ !empty($menu) && $menu=="apps"?"active":"" }}">
            <i class="fas fa-circle nav-icon"></i>
            <p>Apps</p>
        </a>
    </li>
    {{-- <li class="nav-item">
        <a href="{{ url('admin/contactus') }}" class="nav-link  {{ !empty($menu) && $menu=="contactus"?"active":"" }}">
            <i class="fas fa-circle nav-icon"></i>
            <p>Contact Us</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ url('admin/plan') }}" class="nav-link  {{ !empty($menu) && $menu=="plan"?"active":"" }}">
            <i class="fas fa-circle nav-icon"></i>
            <p>Plan</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ url('admin/profile') }}" class="nav-link  {{ !empty($menu) && $menu=="profile"?"active":"" }}">
            <i class="fas fa-circle nav-icon"></i>
            <p>Profile</p>
        </a>
    </li> --}}
    <li class="nav-item ">
        <a href="{{ url('admin/logout') }}" class="nav-link text-danger" >
            <i class="fas fa-sign-out-alt nav-icon"></i>
            <p>Logout</p>
        </a>
    </li>

</ul>