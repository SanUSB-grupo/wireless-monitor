<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/x-icon" href="{{ asset('img/favicon.ico') }}"/>
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/favicon.ico') }}"/>
        <title>Wireless Monitor</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css" crossorigin="anonymous">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

        <!-- Styles -->
        <link href="{{ elixir('vendor/vendor.css') }}" rel="stylesheet">
        @stack('styles')
    </head>
    <body id="app-layout">
        <nav class="navbar navbar-inverse navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed"
                        data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img alt="logo" src="{{ asset('img/logo.png') }}" />
                        Wireless Monitor
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        <li class="@isActive('/monitor')">
                            <a href="{{ url('/monitor') }}">
                                    Monitors
                            </a>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        @auth
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                                </ul>
                            </li>
                        @else
                            <li class="@isActive('/login')">
                                <a href="{{ url('/login') }}">Login</a>
                            </li>
                            <li class="@isActive('/register')">
                                <a href="{{ url('/register') }}">Register</a>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>

        @yield('container')

        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <h4>Wireless Monitor</h4>
                        <ul class="nav">
                            <li>
                                <a href="https://github.com/sanusb-grupo/wireless-monitor"
                                    target="_blank">
                                    <i class="fa fa-github"></i>
                                    Source Code
                                </a>
                            </li>
                            <li>
                                <a href="https://sanusb-grupo.github.io/wireless-monitor/"
                                    target="_blank">
                                    <i class="fa fa-book"></i>
                                    Documentation
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>

        <!-- JavaScripts -->
        <script src="{{ elixir('vendor/vendor.js') }}"></script>
        @stack('scripts')
    </body>
</html>
