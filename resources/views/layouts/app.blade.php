<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Xor Admin') }}</title>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light"
          rel="stylesheet" type="text/css">

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.css') }}"/>


    <link rel="stylesheet" href="{{ asset('assets/vendor/font-awesome/css/font-awesome.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/vendor/magnific-popup/magnific-popup.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.css') }}"/>

    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/css/select2.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2-bootstrap-theme/select2-bootstrap.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/vendor/jquery-datatables-bs3/assets/css/datatables.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-timepicker/css/bootstrap-timepicker.css') }}"/>

    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.3/css/fixedHeader.dataTables.min.css"/>

    <link rel="stylesheet" href="{{ asset('assets/stylesheets/theme.css') }}"/>

    <!-- Skin CSS -->
    <link rel="stylesheet" href="{{ asset('assets/stylesheets/skins/default.css') }}"/>

    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/stylesheets/theme-custom.css') }}">
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- Head Libs -->
    @yield('style')
    {{--<script src="{{ asset('assets/vendor/jquery/jquery.js') }}"></script>--}}

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="{{ asset('assets/vendor/select2/js/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-datatables/media/js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-datatables-bs3/assets/js/datatables.js') }}"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.2.3/js/dataTables.fixedHeader.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="{{ asset('assets/vendor/modernizr/modernizr.js') }}"></script>
    <style>
        .custom-avatar {
            position: relative;
            overflow: clip;
            border: 1px solid lightgray;
            border-radius: 50%;
            height: 40px;
            width: 40px;
        }

        .custom-avatar img {
            width: unset !important;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            max-width: 100%;
            max-height: 100%;
            border-radius: 0;
        }
    </style>
</head>
<body>
<section class="body">
    <!-- start: header -->
    <header class="header header-nav-menu header-nav-top-line">
        <div class="logo-container">
            <a href="../" class="logo">
                <img src="{{ asset('assets/images/logo.png') }}" width="75" height="35" alt="Porto Admin"/>
            </a>
            <div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html"
                 data-fire-event="sidebar-left-opened">
                <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
            </div>
        </div>

        <!-- start: search & user box -->
        <div class="header-right">
            <div id="userbox" class="userbox mt-sm">
                <a href="#" data-toggle="dropdown">
                    <figure class="profile-picture custom-avatar">
                        <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->avatar }}"
                             class="img-circle"
                             data-lock-picture="assets/images/!logged-user.jpg"/>
                    </figure>
                    <div class="profile-info" data-lock-name="John Doe" data-lock-email="johndoe@okler.com">
                        <span class="name">{{ Auth::user()->name }}</span>
                        <span class="role">{{ Auth::user()->approve == '2' ? "Administrator" : "User"}}</span>
                    </div>

                    <i class="fa custom-caret"></i>
                </a>

                <div class="dropdown-menu">
                    <ul class="list-unstyled">
                        <li class="divider"></li>
                        {{--<li>--}}
                        {{--<a role="menuitem" tabindex="-1" href="pages-user-profile.html"><i class="fa fa-user"></i> My Profile</a>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                        {{--<a role="menuitem" tabindex="-1" href="#" data-lock-screen="true"><i class="fa fa-lock"></i> Lock Screen</a>--}}
                        {{--</li>--}}
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- end: search & user box -->
    </header>
    <!-- end: header -->
    <div class="inner-wrapper">
        <!-- start: sidebar -->
        <aside id="sidebar-left" class="sidebar-left">
            <div class="sidebar-header">
                <div class="sidebar-title">
                    Admin Page
                </div>
                <div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html"
                     data-fire-event="sidebar-left-toggle">
                    <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
                </div>
            </div>

            <div class="nano">
                <div class="nano-content">
                    <nav id="menu" class="nav-main" role="navigation">
                        <ul class="nav nav-main">
                            @if(Auth::user()->approve == '3')
                                <li>
                                    <a href="{{ route('usersManagement') }}">
                                        <i class="fa fa-user" aria-hidden="true"></i>
                                        <span>Users Management</span>
                                    </a>
                                </li>
                            @endif
                            @if(Auth::user()->CanSee('see_home'))
                                <li>
                                    <a href="{{ route('home') }}">
                                        <i class="fa fa-home" aria-hidden="true"></i>
                                        <span>Home</span>
                                    </a>
                                </li>
                            @endif
                            @if(Auth::user()->CanSee('see_screenshots'))
                                <li>
                                    <a href="{{ route('screenshots') }}">
                                        <i class="fa fa-image" aria-hidden="true"></i>
                                        <span>Screenshots</span>
                                    </a>
                                </li>
                            @endif
                            @if(Auth::user()->CanSee('see_hack_logs'))
                                <li>
                                    <a href="{{ route('logs') }}">
                                        <i class="fa fa-desktop" aria-hidden="true"></i>
                                        <span>Hack Logs</span>
                                    </a>
                                </li>
                            @endif
                            @if(Auth::user()->CanSee('see_connect_logs'))
                                <li>
                                    <a href="{{ route('cnlogs') }}">
                                        <i class="fa fa-list" aria-hidden="true"></i>
                                        <span>Connect Logs</span>
                                    </a>
                                </li>

                            @endif
                            @if(Auth::user()->CanSee('see_tools_download'))
                                <li>
                                    <a href="{{ route('downloads') }}">
                                        <i class="fa fa-download" aria-hidden="true"></i>
                                        <span>Tools Download</span>
                                    </a>
                                </li>
                            @endif
                            @if(Auth::user()->approve > 1)
                                <li>
                                    <a href="{{ route('license') }}">
                                        <i class="fa fa-drivers-license" aria-hidden="true"></i>
                                        <span>License</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('licenseSetting') }}">
                                        <i class="fa fa-drivers-license" aria-hidden="true"></i>
                                        <span>License Setting</span>
                                    </a>
                                </li>
                            @endif
                            @if(Auth::user()->CanSee('see_guides'))
                                <li>
                                    <a href="{{ route('guides') }}">
                                        <i class="fa fa-folder" aria-hidden="true"></i>
                                        <span>Guides</span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </nav>
                </div>

                <script>
                    // Maintain Scroll Position
                    if (typeof localStorage !== 'undefined') {
                        if (localStorage.getItem('sidebar-left-position') !== null) {
                            var initialPosition = localStorage.getItem('sidebar-left-position'),
                                sidebarLeft = document.querySelector('#sidebar-left .nano-content');

                            sidebarLeft.scrollTop = initialPosition;
                        }
                    }
                </script>
            </div>
        </aside>
        <!-- end: sidebar -->
        @yield('content')
    </div>

</section>


<!-- Vendor -->

<script src="{{ asset('assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js') }}"></script>
<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.js') }}"></script>
<script src="{{ asset('assets/vendor/nanoscroller/nanoscroller.js') }}"></script>
<script src="{{ asset('assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('assets/vendor/magnific-popup/jquery.magnific-popup.js') }}"></script>
<script src="{{ asset('assets/vendor/jquery-loading/ajax-loading.js') }}"></script>
<script src="{{ asset('assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('assets/vendor/bootstrap-timepicker/bootstrap-timepicker.js') }}"></script>

<!-- Specific Page Vendor -->


<!-- Theme Base, Components and Settings -->
<script src="{{ asset('assets/javascripts/theme.js') }}"></script>

<!-- Theme Custom -->
<script src="{{ asset('assets/javascripts/theme.custom.js') }}"></script>

<!-- Theme Initialization Files -->
<script src="{{ asset('assets/javascripts/theme.init.js') }}"></script>

<!-- Examples -->
<script src="{{ asset('assets/javascripts/dashboard/examples.dashboard.js') }}"></script>
<script src="{{ asset('assets/javascripts/loading.js') }}"></script>

@yield('script')
</body>
</html>
