<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>@yield('title') | Yönetim Paneli</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Yönetim Paneli" name="description" />
    <meta content="Egemen KIRKAPLAN" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    @yield('cssBefore')
    <!-- Bootstrap Css -->
    <link href="{{ asset('backend/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('backend/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('backend/assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/assets/libs/toastr/build/toastr.min.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('cssAfter')
</head>

<body data-sidebar="dark">

<!-- Begin page -->
<div id="layout-wrapper">

    <header id="page-topbar">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box">
                    <a href="{{ route('panel.home.index') }}" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="{{ asset('backend/assets/images/logo-white.png') }}" alt="" height="22">
                                </span>
                        <span class="logo-lg">
                                    <img src="{{ asset('backend/assets/images/logo-white.png') }}" alt="" height="20">
                                </span>
                    </a>

                    <a href="{{ route('panel.home.index') }}" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="{{ asset('backend/assets/images/logo-white.png') }}" alt="" height="22">
                                </span>
                        <span class="logo-lg">
                                    <img src="{{ asset('backend/assets/images/logo-white.png') }}" alt="" height="20">
                                </span>
                    </a>
                </div>

                <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                    <i class="ri-menu-2-line align-middle"></i>
                </button>
            </div>

            <div class="d-flex">
                <div class="dropdown d-inline-block user-dropdown">
                    <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img class="rounded-circle header-profile-user" src="{{ asset('backend/assets/images/users/avatar-2.jpg') }}"
                             alt="Header Avatar">
                        <span class="d-none d-xl-inline-block ml-1">{{ auth()->user()->name }}</span>
                        <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-danger" href="{{ route('panel.auth.logout') }}"><i class="ri-shut-down-line align-middle mr-1 text-danger"></i> Çıkış Yap</a>
                    </div>
                </div>

            </div>
        </div>
    </header>

    <!-- ========== Left Sidebar Start ========== -->
    @include('Backend.Layout.sidebar')
    <!-- Left Sidebar End -->

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">
                @yield('content')
            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <script>document.write(new Date().getFullYear())</script> © Vue Laravel Blog.
                    </div>
                    <div class="col-sm-6">
                        <div class="text-sm-right d-none d-sm-block">
                            Crafted with <i class="mdi mdi-heart text-danger"></i> by Egemen Kırkaplan
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <!-- end main content-->

</div>
<!-- END layout-wrapper -->

@yield('jsBefore')
<!-- JAVASCRIPT -->
<script src="{{ asset('backend/assets/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('backend/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('backend/assets/libs/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ asset('backend/assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('backend/assets/libs/node-waves/waves.min.js') }}"></script>
<script src="{{ asset('backend/assets/libs/toastr/build/toastr.min.js') }}"></script>
<script src="{{ asset('backend/assets/js/pages/toastr.init.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js" integrity="sha256-qIEdjJD0ON7AbXQpi7N1CBcZy2AqQNoyWXLMTye8Qbc=" crossorigin="anonymous"></script>
<script src="{{ asset('backend/assets/js/app.js') }}"></script>
@if (session('success'))
    <script>
        toastr.success("{{ session('success') }}");
    </script>
@endif
@if (session('error'))

@endif

@if ($errors->any())
    <script>
        @foreach ($errors->all() as $error)
        toastr.error("{{ $error }}");
        @endforeach
    </script>
@endif

@yield('jsAfter')
</body>
</html>
