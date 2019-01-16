<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="level" content="{{ Auth::user()->role()->name }}">
    <meta name="env-level" content="{{ env('CALEG_LEVEL', 'dpr') }}">
    <title>{{ config('app.name') }} - {{ config('app.desc') }}</title>

    <script src="{{ asset('js/app.js') }}" defer></script>

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
    <div id="app" class="wrapper">
        <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <a href="{{ url('/') }}" class="brand-link bg-danger mx-auto py-0 d-inline-block d-sm-none">
                <img src="{{ asset('images/sipileg-sm.png') }}" alt="APP Logo" class="brand-image">
            </a>

            {{-- Right Menu --}}
            <ul class="navbar-nav ml-sm-auto">
                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li>
            </ul>
        </nav>

        <aside class="main-sidebar sidebar-dark-primary elevation-4" style="overflow-x: hidden;">
            <a href="{{ url('/') }}" class="brand-link">
                <img src="{{ asset('images/logo-m-90x90.png') }}" alt="APP Logo" class="brand-image img-circle">
                <span class="brand-text font-weight-bold">{{ config('app.name') }}</span>
            </a>

            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset('images/profile.png') }}" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">{{ Auth::user()->name }}</a>
                    </div>
                </div>

                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <router-link :to="{ name: 'home' }" class="nav-link close-sidebar">
                                <i class="fas fa-home nav-icon"></i>
                                <p>Home</p>
                            </router-link>
                        </li>
                        <li class="nav-header">ADMIN MENU</li>
                        <li class="nav-item">
                            <router-link :to="{ name: 'admin.dashboard' }" class="nav-link close-sidebar">
                                <i class="fas fa-tachometer-alt nav-icon"></i>
                                <p class="ml-1">Dashboard</p>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link :to="{ name: 'admin.candidate' }" class="nav-link close-sidebar">
                                <i class="fas fa-user-tie nav-icon"></i>
                                <p class="ml-1">Calon Legislatif</p>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link :to="{ name: 'admin.coordinators' }" class="nav-link close-sidebar">
                                <i class="fas fa-users nav-icon"></i>
                                <p class="ml-1">Kordinator</p>
                            </router-link>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <div class="content-wrapper">
            @yield('content')
        </div>

        <aside class="control-sidebar control-sidebar-light">
            <div class="p-3">
                <img src="{{ asset('images/user.png') }}" class="img-fluid mx-auto d-block rounded-circle" style="width: 75px">
                <div class="pt-2 text-center">
                    <h5 class="mb-0">{{ Auth::user()->name }}</h5>
                    <p>{{ Auth::user()->roles[0]->display_name ?? '-' }}</p>
                </div>
                <hr class="mt-0">
                <button class="btn btn-outline-danger btn-block" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt mr-1"></i> Logout
                </button>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </aside>
    </div>
</body>
</html>
