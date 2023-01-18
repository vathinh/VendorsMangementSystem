<html lang="en-GB">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8; charset=ISO-8859-1" />

    <title>@yield('title')</title>


    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('img/logo.jpg') }}" type="image/png">

    <!-- Font -->
    <link rel="stylesheet" href="{{ asset('vendor/opensans/css/opensans.css?v=') }}" type="text/css">

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('vendor/nucleo/css/nucleo.css?v=') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/all.min.css?v=') }}" type="text/css">

    <!-- Css -->
    <link rel="stylesheet" href="{{ asset('css/argon.css?v=') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/sas_color.css?v=') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/custom.css?v=') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/element.css?v=') }}" type="text/css">

    <script>
        window.Laravel = {
            "csrfToken": "{{ csrf_token() }}"
        }

    </script>

</head>

<body id="leftMenu" class="g-sidenav-show">

    <nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light bg-default" id="sidenav-main">
        <div class="scrollbar-inner">
            <div class="sidenav-header d-flex align-items-center">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="/home" role="button">
                            <span class="avatar menu-avatar background-unset">
                                <img class="border-radius-none border-0 mr-3" alt="sas" src="{{ asset('img/logo.jpg') }}">
                            </span>
                            <span class="nav-link-text long-texts pl-2 mwpx-100">@if(session('user')) {{ session('user')[0]->fullname }}@else Guest @endif</span>
                        </a>
                    </li>
                </ul>
                <div class="ml-auto left-menu-toggle-position overflow-hidden">
                    <div class="sidenav-toggler d-none d-xl-block left-menu-toggle" data-action="sidenav-unpin" data-target="#sidenav-main">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="navbar-inner">
                <!-- Collapse -->
                <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                    <!-- Nav items -->
                    <ul class="navbar-nav">
                        @if (substr(session('user')[0]->role,0,2)=="HR"||substr(session('user')[0]->role,0,2)=="MA")
                            <li class="nav-item"> <a class="nav-link" href="/users/index"><i class="fa fa-user"></i> <span class="nav-link-text">Users</span> </a>
                            </li>
                        @endif

                        @if (substr(session('user')[0]->role,0,2)!="HR")
                            <li class="nav-item"> <a class="nav-link" href="/products/index"><i class="fa fa-cube"></i>
                                    <span class="nav-link-text">Products</span></a></li>
                        @endif
                        @if (substr(session('user')[0]->role,0,2)=="SA"||substr(session('user')[0]->role,0,2)=="MA"||substr(session('user')[0]->role,0,2)=="AC")
                            <li class="nav-item"> <a class="nav-link" href="/customers/index"><i class="fa fa-portrait"></i>
                                    <span class="nav-link-text">Customers</span> </a></li>
                        @endif

                        @if (substr(session('user')[0]->role,0,2)=="LO"||substr(session('user')[0]->role,0,2)=="MA"||substr(session('user')[0]->role,0,2)=="AC")
                            <li class="nav-item"> <a class="nav-link" href="/vendors/index"><i class="fa fa-user-tie"></i>
                                    <span class="nav-link-text">Vendors</span> </a></li>
                        @endif


                        @if (substr(session('user')[0]->role,0,2)!="HR")
                        <li class="nav-item">
                            <a class="nav-link" href="#navbar-sales" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-sales">
                                <i class="fa fa-money-bill"></i>
                                <span class="nav-link-text">Sales</span>
                            </a>
                            <div class="collapse" id="navbar-sales">
                                <ul class="nav nav-sm flex-column">
                                    @if (substr(session('user')[0]->role,0,2)=="SA"||substr(session('user')[0]->role,0,2)=="MA")
                                        <li class="nav-item"> <a class="nav-link" href="/saleorders/index"> <span class="nav-link-text">Sale Orders</span> </a></li>
                                    @endif

                                    @if (substr(session('user')[0]->role,0,2)=="AC"||substr(session('user')[0]->role,0,2)=="MA")
                                        <li class="nav-item"> <a class="nav-link" href="/invoices/index"> <span class="nav-link-text">Invoices</span> </a></li>
                                        <li class="nav-item"> <a class="nav-link" href="/receivables/index"> <span class="nav-link-text">Receivables</span> </a></li>
                                    @endif

                                    @if (substr(session('user')[0]->role,0,2)=="LO"||substr(session('user')[0]->role,0,2)=="MA")
                                        <li class="nav-item"> <a class="nav-link" href="/exports/index"> <span class="nav-link-text">Exports</span> </a></li>
                                    @endif
                                </ul>
                            </div>
                        </li>
                        @endif


                        @if (substr(session('user')[0]->role,0,2)!="SA"&&substr(session('user')[0]->role,0,2)!="HR")
                        <li class="nav-item">
                            <a class="nav-link" href="#navbar-purchases" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-purchases">
                                <i class="fa fa-shopping-cart"></i>
                                <span class="nav-link-text">Purchases</span>
                            </a>
                            <div class="collapse" id="navbar-purchases">
                                <ul class="nav nav-sm flex-column">

                                    @if (substr(session('user')[0]->role,0,2)=="LO"||substr(session('user')[0]->role,0,2)=="MA")
                                        <li class="nav-item"> <a class="nav-link" href="/purchaseorders/index"> <span class="nav-link-text">Purchase Orders</span> </a></li>
                                    @endif

                                    @if (substr(session('user')[0]->role,0,2)=="AC"||substr(session('user')[0]->role,0,2)=="MA")
                                        <li class="nav-item"> <a class="nav-link" href="/bills/index"> <span class="nav-link-text">Bills</span> </a></li>
                                        <li class="nav-item"> <a class="nav-link" href="/payables/index"> <span class="nav-link-text">Payables</span> </a></li>
                                    @endif

                                    @if (substr(session('user')[0]->role,0,2)=="LO"||substr(session('user')[0]->role,0,2)=="MA")
                                        <li class="nav-item"> <a class="nav-link" href="/imports/index"> <span class="nav-link-text">Imports</span> </a></li>
                                    @endif

                                </ul>
                            </div>
                        </li>
                        @endif

                        @if (substr(session('user')[0]->role,0,2)=="AC"||substr(session('user')[0]->role,0,2)=="MA"||substr(session('user')[0]->role,0,2)=="SA")
                            <li class="nav-item"> <a class="nav-link" href="/reports/index"><i class="fa fa-chart-pie"></i> <span class="nav-link-text">Reports</span> </a></li>
                        @endif

                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="main-content" id="panel">
        <nav class="navbar navbar-top navbar-expand navbar-dark border-bottom">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    {{--
                    <form class="navbar-search navbar-search-light form-inline mb-0" id="navbar-search-main" autocomplete="off">
                        <div class="form-group mb-0 mr-sm-3">
                            <div class="input-group input-group-alternative input-group-merge">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-search"></i></span>
                                </div>
                                <input type="text" name="search" class="form-control" autocomplete="off" placeholder="Search">
                            </div>
                        </div>
                    </form> --}}

                    <ul class="navbar-nav align-items-center ml-md-auto">
                        <li class="nav-item d-xl-none">
                            <div class="pr-3 sidenav-toggler sidenav-toggler-dark" data-action="sidenav-pin" data-target="#sidenav-main">
                                <div class="sidenav-toggler-inner">
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                </div>
                            </div>
                        </li>

                        <li class="nav-item d-sm-none">
                            <a class="nav-link" href="#" data-action="search-show" data-target="#navbar-search-main">
                                <i class="fa fa-search"></i>
                            </a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-plus"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-dark dropdown-menu-right">
                                <div class="row shortcuts px-4">

                                    <a href="/saleorders/index" class="col-4 shortcut-item">
                                        <span class="shortcut-media avatar rounded-circle bg-gradient-info">
                                            <i class="fa fa-money-bill"></i>
                                        </span>
                                        <small class="text-info">Sale Orders</small>
                                    </a>


                                    <a href="/invoices/index" class="col-4 shortcut-item">
                                        <span class="shortcut-media avatar rounded-circle bg-gradient-info">
                                            <i class="fas fa-hand-holding-usd"></i>
                                        </span>
                                        <small class="text-info">Invoices</small>
                                    </a>

                                    <a href="/receivables/index" class="col-4 shortcut-item">
                                        <span class="shortcut-media avatar rounded-circle bg-gradient-info">
                                            <i class="fas fa-user"></i>
                                        </span>
                                        <small class="text-info">Receivalbes</small>
                                    </a>


                                    <a href="/purchaseorders/index" class="col-4 shortcut-item">
                                        <span class="shortcut-media avatar rounded-circle bg-gradient-danger">
                                            <i class="fa fa-shopping-cart"></i>
                                        </span>
                                        <small class="text-danger">Purchase Orders</small>
                                    </a>


                                    <a href="/bills/index" class="col-4 shortcut-item">
                                        <span class="shortcut-media avatar rounded-circle bg-gradient-danger">
                                            <i class="fas fa-hand-holding-usd"></i>
                                        </span>
                                        <small class="text-danger">Bills</small>
                                    </a>


                                    <a href="/payables/index" class="col-4 shortcut-item">
                                        <span class="shortcut-media avatar rounded-circle bg-gradient-danger">
                                            <i class="fas fa-user"></i>
                                        </span>
                                        <small class="text-danger">Payables</small>
                                    </a>

                                </div>
                            </div>
                        </li>


                        <li class="nav-item dropdown">
                            <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span>
                                    <i class="far fa-bell"></i>
                                </span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right py-0 overflow-hidden">
                                <div class="list-group list-group-flush">

                                </div>
                                <a class="dropdown-item text-center text-primary font-weight-bold py-3">You have no
                                    notification</a>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="" title="0 Updates Available" role="button" aria-haspopup="true" aria-expanded="false">
                                <span>
                                    <i class="fa fa-sync-alt"></i>
                                </span>
                            </a>
                        </li>

                        <li class="nav-item d-none d-md-block">
                            <a class="nav-link" href="" target="_blank" title="Help" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="far fa-life-ring"></i>
                            </a>
                        </li>

                    </ul>

                    <ul class="navbar-nav align-items-center ml-auto ml-md-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                <div class="media align-items-center">
                                    <img src="{{ asset('img/user.svg') }}" class="user-img" alt="" />
                                </div>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right">

                                <div class="dropdown-header noti-title">
                                    <h6 class="text-overflow m-0">Welcome</h6>
                                </div>
                                @if(session('user'))
                                <a href="/users/show/{{ session('user')[0]->userID }}" class="dropdown-item">
                                    <i class="fas fa-user"></i>
                                    <span>Profile</span>
                                </a>
                                @endif
                                <div class="dropdown-divider"></div>

                                <a href="/logout" class="dropdown-item">
                                    <i class="fas fa-power-off"></i>
                                    <span>Logout</span>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div id="main-body">

            <div id="header" class="header pb-6">
                <div class="container-fluid content-layout">
                    <div class="header-body">
                        <div class="row py-4 align-items-center">
                            <div class="col-xs-12 col-sm-4 col-md-5 align-items-center">
                                {{-- Title --}}
                                <h2 class="d-inline-flex mb-0 long-texts"> @yield('title') </h2>
                            </div>
                            <div class="col-xs-12 col-sm-8 col-md-7">
                                <div class="text-right">
                                    {{-- Add New Button --}}
                                    @yield('addnew')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid content-layout mt--6">
                <div id="app">

                    {{-- Content Section --}}
                    @yield('content')

                </div>

                <footer class="footer">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <div class="text-sm float-left text-muted footer-texts">
                                Powered By SAS: LKPD Corporate
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div class="text-sm float-right text-muted footer-texts">
                                Version 1.4.1
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>

    <!-- Core -->
    <script src="{{ asset('vendor/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/js-cookie/js.cookie.js') }}"></script>

    {{-- <script src="{{ asset('js/common/items.js?v=2.1.16') }}"></script> --}}

    {{--  <script src="{{ asset('vendor/chart.js/dist/Chart.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/echarts/4.0.2/echarts-en.min.js" charset=utf-8></script>  --}}

    {{-- Link database --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js">
    </script>
    {{-- End Link database --}}

    @yield('script')


    <!-- Side Navbar Dashboard -->
    <script type="text/javascript">
        'use strict';
        var Layout = (function() {
            function pinSidenav() {
                $('.sidenav-toggler').addClass('active');
                $('.sidenav-toggler').data('action', 'sidenav-unpin');
                $('body').removeClass('g-sidenav-hidden').addClass('g-sidenav-show g-sidenav-pinned');
                $('body').append('<div class="backdrop d-xl-none" data-action="sidenav-unpin" data-target=' + $(
                    '#sidenav-main').data('target') + ' />');

                // Store the sidenav state in a cookie session
                Cookies.set('sidenav-state', 'pinned');
            }

            function unpinSidenav() {
                $('.sidenav-toggler').removeClass('active');
                $('.sidenav-toggler').data('action', 'sidenav-pin');
                $('body').removeClass('g-sidenav-pinned').addClass('g-sidenav-hidden');
                $('body').find('.backdrop').remove();

                // Store the sidenav state in a cookie session
                Cookies.set('sidenav-state', 'unpinned');
            }

            // Set sidenav state from cookie

            var $sidenavState = Cookies.get('sidenav-state') ? Cookies.get('sidenav-state') : 'pinned';

            if ($(window).width() > 1200) {
                if ($sidenavState == 'pinned') {
                    pinSidenav()
                }

                if (Cookies.get('sidenav-state') == 'unpinned') {
                    unpinSidenav()
                }
            }

            $("body").on("click", "[data-action]", function(e) {
                e.preventDefault();

                var $this = $(this);
                var action = $this.data('action');
                var target = $this.data('target');

                // Manage actions
                switch (action) {
                    case 'sidenav-pin':
                        pinSidenav();
                        break;

                    case 'sidenav-unpin':
                        unpinSidenav();
                        break;

                    case 'search-show':
                        target = $this.data('target');
                        $('body').removeClass('g-navbar-search-show').addClass('g-navbar-search-showing');

                        setTimeout(function() {
                            $('body').removeClass('g-navbar-search-showing').addClass(
                                'g-navbar-search-show');
                        }, 150);

                        setTimeout(function() {
                            $('body').addClass('g-navbar-search-shown');
                        }, 300)
                        break;

                    case 'search-close':
                        target = $this.data('target');
                        $('body').removeClass('g-navbar-search-shown');

                        setTimeout(function() {
                            $('body').removeClass('g-navbar-search-show').addClass(
                                'g-navbar-search-hiding');
                        }, 150);

                        setTimeout(function() {
                            $('body').removeClass('g-navbar-search-hiding').addClass(
                                'g-navbar-search-hidden');
                        }, 300);

                        setTimeout(function() {
                            $('body').removeClass('g-navbar-search-hidden');
                        }, 500);
                        break;
                }
            })

            // Add sidenav modifier classes on mouse events
            $('.sidenav').on('mouseenter', function() {
                if (!$('body').hasClass('g-sidenav-pinned')) {
                    $('body').removeClass('g-sidenav-hide').removeClass('g-sidenav-hidden').addClass(
                        'g-sidenav-show');
                }
            })

            $('.sidenav').on('mouseleave', function() {
                if (!$('body').hasClass('g-sidenav-pinned')) {
                    $('body').removeClass('g-sidenav-show').addClass('g-sidenav-hide');

                    setTimeout(function() {
                        $('body').removeClass('g-sidenav-hide').addClass('g-sidenav-hidden');
                    }, 300);
                }
            })

            // Make the body full screen size if it has not enough content inside
            $(window).on('load resize', function() {
                if ($('body').height() < 800) {
                    $('body').css('min-height', '100vh');
                    $('#footer-main').addClass('footer-auto-bottom')
                }
            })
        })();

    </script>

</body>

</html>
