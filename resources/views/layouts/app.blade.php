<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Meta -->
    <meta name="description" content="Best Bootstrap Admin Dashboards">
    <meta name="author" content="Bootstrap Gallery" />
    <link rel="canonical" href="https://www.bootstrap.gallery/">
    <meta property="og:url" content="https://www.bootstrap.gallery">
    <meta property="og:description" content="Marketplace for Bootstrap Admin Dashboards">
    <meta property="og:type" content="Website">

    <!-- Title -->
    <title>Fintech</title>


    <!-- *************
   ************ Common Css Files *************
  ************ -->

    <!-- Animated css -->
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">

    <!-- Bootstrap font icons css -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/bootstrap/bootstrap-icons.css') }}">

    <!-- Main css -->
    <link rel="stylesheet" href="{{ asset('assets/css/main.min.css') }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">


    <!-- *************
   ************ Vendor Css Files *************
  ************ -->

    <!-- Scrollbar CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/overlay-scroll/OverlayScrollbars.min.css') }}">

</head>

<body style="overflow: hidden;">

    <!-- Loading wrapper start -->
    {{-- <div id="loading-wrapper">
        <div class="spinner">
            <div class="line1"></div>
            <div class="line2"></div>
            <div class="line3"></div>
            <div class="line4"></div>
            <div class="line5"></div>
            <div class="line6"></div>
        </div>
    </div> --}}
    <!-- Loading wrapper end -->

    <!-- Page wrapper start -->
    <div class="page-wrapper">

        <!-- Sidebar wrapper start -->

        <!-- Sidebar wrapper end -->

        <!-- *************
    ************ Main container start *************
   ************* -->
        <div class="container">

            <!-- Page header starts -->
            <div class="page-header">

                <div class="toggle-sidebar" id="toggle-sidebar"><i class="bi bi-list"></i></div>

                <!-- Breadcrumb start -->
                <ol class="breadcrumb d-md-flex d-none">
                    {{-- <li class="breadcrumb-item">
                            <i class="bi bi-house"></i>
                            <a href="{{ url('/') }}">Home</a>
                        </li> --}}
                    {{-- <li class="breadcrumb-item breadcrumb-active" aria-current="page">Sales</li> --}}
                    <!-- Welcome start -->
                    <div class="welcome-note">
                        @guest
                            Welcome, Fintech
                        @else
                            Welcome, {{ Auth::user()->name }}
                        @endguest
                    </div>
                    <!-- Welcome end -->
                </ol>
                <!-- Breadcrumb end -->

                <!-- Header actions container start -->
                <div class="header-actions-container">

                    <!-- Search and Notification container start -->
                    @auth
                        <!-- Search container start -->
                        {{-- <div class="search-container">

                            <!-- Search input group start -->
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search anything">
                                <button class="btn" type="button">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                            <!-- Search input group end -->

                        </div> --}}
                        <!-- Search container end -->

                        <!-- Leads start -->
                        {{-- <a href="orders.html" class="leads d-none d-xl-flex">
                            <div class="lead-details">You have <span class="count"> 21 </span> new leads </div>
                            <span class="lead-icon"><i
                                    class="bi bi-bell-fill animate__animated animate__swing animate__infinite infinite"></i><b
                                    class="dot animate__animated animate__heartBeat animate__infinite"></b></span>
                        </a> --}}
                        <!-- Leads end -->
                    @endauth
                    <!-- Search and Notification container end -->

                    <!-- Header actions start -->
                    <ul class="header-actions">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    {{-- <a class="dropdown-item" href="{{ route('user.index') }}">
                                            Profile
                                        </a> --}}

                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                        {{-- <li class="dropdown">
                                <a href="#" id="userSettings" class="user-settings" data-toggle="dropdown" aria-haspopup="true">
                                    <span class="" >Abigale Heaney</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userSettings">
                                    <div class="header-profile-actions">
                                        <a href="profile.html">Profile</a>
                                        <a href="">Logout</a>
                                    </div>
                                </div>
                            </li> --}}
                    </ul>
                    <!-- Header actions end -->

                </div>
                <!-- Header actions container end -->

            </div>
            <!-- Page header ends -->

            <!-- Content wrapper scroll start -->
            <div class="content-wrapper-scroll">

                <!-- Content wrapper start -->
                <div class="content-wrapper">

                    @yield('content')

                </div>
                <!-- Content wrapper end -->

            </div>
            <!-- Content wrapper scroll end -->

        </div>
        <!-- *************
    ************ Main container end *************
   ************* -->

    </div>
    <!-- Page wrapper end -->


    <!-- *************
   ************ Required JavaScript Files *************
  ************* -->
    <!-- Required jQuery first, then Bootstrap Bundle JS -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/modernizr.js') }}"></script>
    <script src="{{ asset('assets/js/moment.js') }}"></script>

    <!-- *************
   ************ Vendor Js Files *************
  ************* -->

    <!-- Overlay Scroll JS -->
    <script src="{{ asset('assets/vendor/overlay-scroll/jquery.overlayScrollbars.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/overlay-scroll/custom-scrollbar.js') }}"></script>

    <!-- Apex Charts -->
    <script src="{{ asset('assets/vendor/apex/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/apex/custom/sales/salesGraph.js') }}"></script>
    <script src="{{ asset('assets/vendor/apex/custom/sales/revenueGraph.js') }}"></script>
    <script src="{{ asset('assets/vendor/apex/custom/sales/taskGraph.js') }}"></script>

    <!-- Main Js Required -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

</body>

</html>