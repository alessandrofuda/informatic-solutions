<!DOCTYPE html>
<html lang="en">
<head>
    <!--meta charset="utf-8"-->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="index,follow"> {{-- il comparatore è DE-INDICIZZATO !! --}}
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ url('images-hp/favicon.png') }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @if( !empty($slug) )
        <title>{{ ucfirst($slug) }}, comparatore prezzi</title>
        <meta name="description" content="Tutte le informazioni utili, recensioni e confronto prezzi sui {{ ucfirst($slug) }}">
    @endif

    <!-- Styles -->
    <link href="{{ url('css/app.css') }}" rel="stylesheet">
    <link href="{{ url('css/comparator-child.css') }}" rel="stylesheet">
    @if (Route::currentRouteName('home'))
        <link href="{{ url('css/homepage-child.css') }}" rel="stylesheet">
    @endif

    <!-- Scripts -->
    <script src="/js/app.js"></script>

    <!-- jQuery-UI -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <!--j-rating jquery plugin-->
    <link href="/j-rating/src/j-rating-advance/j-rating-advance.css" rel="stylesheet">
    <script src="/j-rating/src/j-rating-advance/j-rating-advance.js"></script>

    <!-- datatables jquery plugin-->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.16/r-2.2.1/datatables.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.16/r-2.2.1/datatables.min.js"></script>

    <!-- autocomplete jquery plugin -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-autocomplete/1.0.7/jquery.auto-complete.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-autocomplete/1.0.7/jquery.auto-complete.min.js"></script>

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="navbar-header">
                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    <!--img class="logo" src="{{-- asset('/images-comp/informatic-solutions-logo.png') --}}" alt="Comparatore Prezzi - Informatic Solutions"-->
                    <i class="fas fa-cogs"></i>Informatic-solutions
                </a>
            </div>
            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    &nbsp;
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li>
                            <a href="{{ url('/login') }}">
                                <button class="btn btn-default">Accedi</button>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/register') }}">
                                <button class="btn btn-primary">Registrati</button>
                            </a>
                        </li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                <button class="btn btn-default">{{ Auth::user()->name }} <span class="caret"></span></button>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('backend') }}">Profilo</a></li>
                                <li><a href="{{ url('backend#my-list') }}">Oggetti in osservazione</a></li>
                                <li><a href="{{ url('backend#reset-psw') }}">Cambia password</a></li>
                                <li><a href="">Modifica profilo-FARE</a></li>
                                <li>
                                    <a href="{{ url('backend/delete/my-profile') }}" onclick="return confirm('Sei sicuro di voler eliminare il tuo Profilo e Dis-iscriverti dal servizio?')">Elimina profilo</a>
                                </li>
                                <hr style="margin:10px auto;">
                                <li>
                                    <a href="{{ url('/logout') }}"
                                        onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </nav>

        @if(Session::has('success_message')) {{-- variabili di sessione per alerts --}}
          <div id="alert" class="alert alert-success text-center alert-dismissable fade in">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {!! Session::get('success_message') !!}
          </div>
        @endif

        @if(Session::has('error_message')) 
          <div id="alert" class="alert alert-danger text-center alert-dismissable fade in">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {!! Session::get('error_message') !!}
          </div>
        @endif

        <!--start content-->
        @yield('content')
        <!--end content-->

        <footer class="footer" role="contentinfo">
          <div class="container">
            <p class="text-center first">Informatic-Solutions.it - P.Iva 08497200967 - Tutti i diritti riservati © {{ date('Y') }}</p>
            @if (!Route::currentRouteName('home'))
                <p class="text-center small">La duplicazione anche parziale dei contenuti è severamente vietata; le violazioni saranno segnalate alle autorità competenti e perseguite ai termini di legge</p>
            @endif
          </div>  
        </footer>
    </div><!--#app-->

</body>
</html>
