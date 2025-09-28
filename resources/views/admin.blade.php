<!----------------Header------------------->
@include('backend.layouts.header')
@stack('css')
<!----------------Header------------------->

<body>
    <div class="wrapper">

        <!----------------Sidebar------------------->
        @include('backend.layouts.sidebar')
        <!----------------Sidebar------------------->

        <div class="main">

        <!----------------Sidebar------------------->
        @include('backend.layouts.navbar')
        <!----------------Sidebar------------------->

            <main class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 page-title">
                            <div class="left-title">
                                <h1 class="h3">{{ $page_title }}</h1>
                            </div>
                            <div class="page-title-right">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('dashboard') }}">Home</a><i class="align-middle"
                                            data-feather="chevron-right"></i>
                                    </li>
                                    <li class="breadcrumb-item active">
                                        {{ $page_title ?? '' }}
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    
                    @yield('content')
                </div>

            </main>

            <!----------------Footer------------------->
            @include('backend.layouts.footer')
            <!----------------Footer------------------->

        </div>
    </div>

    <!----------------Script------------------->
    @include('backend.layouts.script')
    <!----------------Script------------------->
</body>

</html>
