<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="" href="{{ route('dashboard') }}">
            <span class="align-middle logo">
                <img src="{{ asset('backend/img/logo/logo.png') }}" class="img-fluid">
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
                <a class="sidebar-link" href="">
                    <i class="align-middle" data-feather="layers"></i> <span class="align-middle">Category</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="">
                    <i class="align-middle" data-feather="codepen"></i> <span class="align-middle">Blog</span>
                </a>
            </li>

            <li class="sidebar-item {{ request()->routeIs('uploaded-files.index') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('uploaded-files.index') }}">
                    <i class="align-middle" data-feather="file-text"></i> <span class="align-middle">Files</span>
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

            <li class="sidebar-header">
                Tools & Components
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="">
                    <i class="align-middle" data-feather="align-left"></i> <span class="align-middle">Staffs</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link d-flex align-items-center justify-content-between collapsed"
                    data-bs-toggle="collapse" href="#languageMenu" role="button" aria-expanded="false">
                    <div>
                        <i class="fa-solid fa-language"></i>
                        <span class="align-middle">Languages</span>
                    </div>
                    <i class="fa-solid fa-chevron-right toggle-icon"></i>
                </a>
                <ul class="collapse list-unstyled ms-3" id="languageMenu">
                    <li>
                        <a class="sidebar-link d-flex align-items-center" href="{{ route('languages.index') }}">
                            <i class="fa-solid fa-minus me-2"></i>
                            Languages
                        </a>
                    </li>
                    <li>
                        <a class="sidebar-link d-flex align-items-center" href="{{ route('languages.create') }}">
                            <i class="fa-solid fa-minus me-2"></i>
                            Add New
                        </a>
                    </li>
                </ul>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link d-flex align-items-center justify-content-between collapsed"
                    data-bs-toggle="collapse" href="#settingMenu" role="button" aria-expanded="false">
                    <div>
                        <i class="align-middle" data-feather="settings"></i> <span class="align-middle">Settings</span>
                    </div>
                    <i class="fa-solid fa-chevron-right toggle-icon"></i>
                </a>
                <ul class="collapse list-unstyled ms-3" id="settingMenu">
                    <li>
                        <a class="sidebar-link d-flex align-items-center" href="">
                            <i class="fa-solid fa-minus me-2"></i>
                            Header Setting
                        </a>
                    </li>
                    <li>
                        <a class="sidebar-link d-flex align-items-center" href="">
                            <i class="fa-solid fa-minus me-2"></i>
                            Footer Setting
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
