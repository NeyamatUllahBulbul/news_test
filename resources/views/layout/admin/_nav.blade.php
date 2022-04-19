<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="{{asset('assets/admin/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo"
             class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{asset(get_user_image())}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ auth()->user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item ">
                    <a href="{{route('dashboard')}}" class="nav-link active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a href="{{route('logout')}}" class="nav-link active" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        <i class="nav-icon "></i>
                        <p>Logout</p>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
                <li class="nav-item has-treeview {{ request()->routeIs('user.*') ? 'menu-open' : null }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            Users
                            <i class="fas fa-angle-left right"></i>

                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('user.create') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add User</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('user.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All users</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview {{ request()->routeIs('news.*', 'news_category.*') ? 'menu-open' : null }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            News
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('news_category.index') }}"
                               class="nav-link {{ request()->routeIs('news_category.*') ? 'active' : null }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Category</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('news.create') }}"
                               class="nav-link {{ request()->routeIs('news.create') ? 'active' : null }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add News</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('news.index') }}"
                               class="nav-link {{ request()->routeIs('news.index', 'news.edit') ? 'active' : null }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>News List</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
