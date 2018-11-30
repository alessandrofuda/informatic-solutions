<!DOCTYPE html>
<html lang="en">
<head>
    <!--meta charset="utf-8"-->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="index,follow">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ url('images-hp/favicon.png') }}">

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
                <a class="navbar-brand" href="">
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
                </ul>
            </div>
        </nav>
        <a href="https://www.informatic-solutions.it/videocitofoni" title="videocitofoni">Videocitofoni prezzi e modelli</a>
        <footer class="footer" role="contentinfo">
          <div class="container">
            <p class="text-center first">IS</p>
          </div>  
        </footer>
    </div><!--#app-->

</body>
</html>
