<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a href="{{ route('dashboard') }}" class="d-flex justify-content-center" style="text-decoration: none;">
            <span class="text-center">
                <h2 class="fw-bold mb-0 text-light p-2">Task <span class='text-info'>Module</span></h2>
            </span>
        </a>

        <ul class="sidebar-nav pb-4">
            <li class="sidebar-header">
                Pages
            </li>

            <li class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('dashboard') }}">
                    <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('tasks.index')}}">
                    <i class="align-middle" data-feather="layers"></i> <span class="align-middle">Task</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="">
                    <i class="align-middle" data-feather="codepen"></i> <span class="align-middle">Blog</span>
                </a>
            </li>

            <li class="sidebar-item {{ request()->is('pages-menu*') ? 'active' : '' }}">
                <a class="sidebar-link" href="">
                    <i class="align-middle" data-feather="menu"></i> <span class="align-middle">Menu</span>
                </a>
            </li>

            <li class="sidebar-item {{ request()->is('pages-page*') ? 'active' : '' }}">
                <a class="sidebar-link" href="">
                    <i class="align-middle" data-feather="book"></i> <span class="align-middle">Page</span>
                </a>
            </li>

            <li class="sidebar-item {{ request()->is('pages-user*') ? 'active' : '' }}">
                <a class="sidebar-link" href="">
                    <i class="align-middle" data-feather="user"></i> <span class="align-middle">Users</span>
                </a>
            </li>
        </ul>
    </div>
</nav>
