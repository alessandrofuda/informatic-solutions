<!DOCTYPE html>
<html lang="it">
<head>
    <!--meta charset="utf-8"-->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    @if( !empty($slug) )
        @if ($slug == 'homepage')
            <title>Servizio automatizzato di comparazione e monitoraggio prezzi, Informatic-Solutions</title>
        @else
            <title>{{ ucfirst($slug) }}, comparatore e monitoraggio prezzi {{!empty($current_page) ? '| Pag. '.$current_page : ''}}</title>
        @endif

        @if ($slug == 'login' || $slug == 'register' || $slug == 'reset password')
            <meta name="description" content="User {{ ucfirst($slug) }} form.">
        @elseif($slug == 'homepage')
            <meta name="description" content="Servizio per confrontare e monitorare i prezzi dei prodotti.">
        @else
            <meta name="description" content="Tutte le informazioni utili, recensioni e confronto prezzi sui {{ ucfirst($slug) }} {{!empty($current_page) ? '| Pag. '.$current_page : ''}}">
        @endif
    @endif

    @if( !empty($slug) )
        @if ($slug == 'login' || $slug == 'register' || $slug == 'reset password' )
            <meta name="robots" content="noindex,nofollow">
        @else
            <meta name="robots" content="index,follow">
        @endif
    @else
        <meta name="robots" content="index,follow">
    @endif

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ url('images-hp/favicon.png') }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/comparator-child.css') }}" rel="stylesheet">
    <link href="{{ asset('css/backend-cms-child.css') }}" rel="stylesheet">
    @if (Route::currentRouteName('home'))
        <link href="{{ asset('css/homepage-child.css') }}" rel="stylesheet">
    @endif

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- jQuery-UI -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <!--j-rating jquery plugin-->
    <link href="/j-rating/src/j-rating-advance/j-rating-advance.css" rel="stylesheet">
    <script src="/j-rating/src/j-rating-advance/j-rating-advance.js"></script>

    <!-- datatables jquery plugin-->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.16/r-2.2.1/datatables.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap.min.css"/>
    <script src="https://cdn.datatables.net/v/bs/dt-1.10.16/r-2.2.1/datatables.min.js"></script>

    <!-- autocomplete jquery plugin -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-autocomplete/1.0.7/jquery.auto-complete.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-autocomplete/1.0.7/jquery.auto-complete.min.js"></script>

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>

    <!-- TinyMce WYSIWYG editor -->
    <script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=rh9bw37ljc1mue3ach41mqvxca1ws2au3olpoj378swqdd1s"></script>
    <script>
        tinymce.init({
            selector: '#article-body',
            plugins: 'code print preview searchreplace autolink directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern help colorpicker textcolor',
            toolbar: 'code | formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat',
            image_advtab: true,
            content_css: [
                '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                '//www.tiny.cloud/css/codepen.min.css'
            ],
            link_list: [
                { title: 'My page 1', value: 'http://www.tinymce.com' },
                { title: 'My page 2', value: 'http://www.moxiecode.com' }
            ],
            image_list: [
                { title: 'My page 1', value: 'http://www.tinymce.com' },
                { title: 'My page 2', value: 'http://www.moxiecode.com' }
            ],
            image_class_list: [
                { title: 'None', value: '' },
                { title: 'Some class', value: 'class-name' }
            ],
            importcss_append: true,
            height: 400,
            file_picker_callback: function (callback, value, meta) {
                /* Provide file and text for the link dialog */
                if (meta.filetype === 'file') {
                  callback('https://www.google.com/logos/google.jpg', { text: 'My text' });
                }

                /* Provide image and alt text for the image dialog */
                if (meta.filetype === 'image') {
                  callback('https://www.google.com/logos/google.jpg', { alt: 'My alt text' });
                }

                /* Provide alternative source and posted for the media dialog */
                if (meta.filetype === 'media') {
                  callback('movie.mp4', { source2: 'alt.ogg', poster: 'https://www.google.com/logos/google.jpg' });
                }
            },
            templates: [
                { title: 'Some title 1', description: 'Some desc 1', content: 'My content' },
                { title: 'Some title 2', description: 'Some desc 2', content: '<div class="mceTmpl"><span class="cdate">cdate</span><span class="mdate">mdate</span>My content2</div>' }
            ],
            template_cdate_format: '[CDATE: %m/%d/%Y : %H:%M:%S]',
            template_mdate_format: '[MDATE: %m/%d/%Y : %H:%M:%S]',
            image_caption: true,

            spellchecker_dialog: true,
            spellchecker_whitelist: ['Ephox', 'Moxiecode']
        });
    </script>
</head>
<body class="{{ $page_type ?? ''}}">
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
                    <i class="fas fa-cogs"></i>Informatic-solutions
                </a>
            </div>
            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li>
                            <a href="{{ url('/login') }}">
                                <button class="btn btn-default login">Accedi</button>
                            </a>
                        </li>
                        <!--li>
                            <a href="{{-- url('/register') --}}">
                                <button class="btn btn-primary register">Registrati</button>
                            </a>
                        </li-->
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                <button class="btn btn-default">{{ Auth::user()->name }} <span class="caret"></span></button>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                @php
                                    $path = Auth::user()->getRoutePrefixByRole();
                                @endphp
                                <li>
                                    <a href="{{ Auth::user()->is_admin() ? route($path.'home') : route($path.'home') }}">Profilo</a>
                                </li>
                                @if (Auth::user()->is_subscriber())
                                    <li>
                                        <a href="{{ url('backend#my-list') }}">Oggetti in osservazione</a>
                                    </li>
                                @endif
                                <li>
                                    <a href="{{ route($path.'change-my-pswd') }}">Cambia password</a>
                                </li>
                                <li>
                                    <a href="{{ route($path.'change-my-profile') }}">Modifica profilo</a>
                                </li>
                                <li>
                                    <a href="{{ route($path.'delete-my-profile') }}" onclick="return confirm('Sei sicuro di voler eliminare il tuo Profilo e Dis-iscriverti dal servizio?')">Elimina profilo</a>
                                </li>
                                <hr style="margin:10px auto;">
                                <li>
                                    <a href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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

        @if(Session::has('success_message'))
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

        @if (count($errors) > 0)
            <div class="alert alert-danger" style="position:relative; top:60px;">
              <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
        @endif

        <!--start content-->
        @yield('content')
        <!--end content-->

        <footer class="footer" role="contentinfo">
          <div class="container-fluid">
            <div class="text-center first">Informatic-Solutions.it - P.Iva 08497200967 -
                <span class="discl">Tutti i diritti riservati © {{ date('Y') }}</span>
            </div>
            @if (!Route::currentRouteName('home'))
                <p class="text-center small">La duplicazione anche parziale dei contenuti è severamente vietata; le violazioni saranno segnalate alle autorità competenti e perseguite ai termini di legge</p>
            @endif
          </div>
        </footer>
    </div><!--#app-->
    <script src="{{ asset('js/custom.js') }}"></script>
</body>
</html>
