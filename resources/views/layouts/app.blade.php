<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - @yield('titulo')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('/css/bootstrap.css') }}" >
    <link rel="stylesheet" href="{{ asset('/css/bootstrap4-toggle.css') }}">    
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/inicio.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/laravel_ajustes.css') }}">

    @yield('encabezado_opc')

</head>
<body>
    <div id="app">
        <!--navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow-->
        <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm flex-md-nowrap p-0 fixed-top">
            <div class="container">
               <!--<a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>

                navbar-brand
               -->
                <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="{{ url('/') }}">
                <img src="/images/JollyRoger.png" width="30" height="30"  alt="">
                Tamale Fiesta</a>


                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                       <!-- 
                            <a class="nav-item nav-link @yield('activa1')" href="http://localhost/recetas">Recetas<span class="sr-only">(current)</span></a>
                            <a class="nav-item nav-link @yield('activa2')" href="http://localhost/ingredientes">Ingredientes</a>
                        -->
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('messages.Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('messages.Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="false" aria-expanded="true" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown" >
                                    <a class="dropdown-item" href="/panel_usuario">{{ __('messages.Panel de Usuario') }}</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                    {{ __('messages.Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none; ">
                                    @csrf
                                </form>
                            </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4" style="padding-bottom:0 !important">
            @yield('contenido')
            @yield('content')
        </main>
    </div>

    
    <!-- Scripts --> 

    <script src="https://code.jquery.com/jquery-3.3.1.min.js" ></script>
    @yield('script_opc')
    
    <!--<script src="{{ asset('/js/app.js') }}" ></script>-->
    <script>window.jQuery || document.write('{{ asset('/js/jquery-slim.min.js') }}"><\/script>')</script>    
    <script src="{{ asset('/js/bootstrap.bundle.js') }}" ></script>
    <script src="{{ asset('/js/bootstrap4-toggle.js') }}" ></script>    
    <script src="{{ asset('/js/bs-custom-file-input.js') }}"></script>
    <script src="{{ asset('/js/numer_input_spinner.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <script>
        feather.replace()
    </script>
    
    <!-- JS MENU LATERAL INI -->
        <script src="{{ asset('/js/lz_responsive.js') }}"></script>
    <!-- JS MENU LATERAL FIN -->
    
    <!--SCRIPT FINAL -->
    @yield('script_opc_final')
    
</body>
</html>
