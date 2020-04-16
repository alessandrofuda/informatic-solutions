<!DOCTYPE html>
<html lang="it-IT">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>{{$post->title}}. Costi, Marche e Modelli.</title>
    <meta name="description" content="Tutte le informazioni sui videocitofoni con e senza fili: marche, tipologie, prezzi, qualità e novità sul mercato. Come scegliere la miglior qualità prezzo"/>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="canonical" href="{{ url($post->slug)}}" />

    <meta property="og:locale" content="it_IT" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="{{$post->title}}" />
    <meta property="og:description" content="Tutte le informazioni sui videocitofoni con e senza fili: marche, tipologie, prezzi, qualità e novità sul mercato. Come scegliere la miglior qualità prezzo" />
    <meta property="og:url" content="{{ url($post->slug)}}" />
    <meta property="og:site_name" content="informatic-solutions" />
    <meta property="article:section" content="Videocitofoni" />
    <meta property="article:published_time" content="2014-06-05T16:12:52+01:00" />
    <meta property="article:modified_time" content="2018-01-22T17:56:56+01:00" />
    <meta property="og:updated_time" content="2018-01-22T17:56:56+01:00" />
    <meta property="og:image" content="{{ url('images/videocitofono-300x300.jpg') }}" />
    <meta property="og:image" content="{{ url('images/videocitofono-utilizzabile-da-smartphone-300x274.jpg') }}" />
    <meta property="og:image" content="{{ url('images/cavo-coassiale-per-videocitofoni.jpg') }}" />

    <!-- import fonts + Bootstrap css -->
    <link rel="stylesheet" href="{{ url('css/app.css') }}">
    <link rel="stylesheet" href="{{ url('css/cms-child.css') }}">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
      /*tables*/ 
      table { border: 1px solid #888; font-size: 120%; } td,th{border:1px solid #CCC; padding: 8px;} tr:nth-child(even){background-color: #f2f2f2;} tr:hover {background-color: #ddd;} th { font-weight: bold; padding-top: 12px; padding-bottom: 12px; background:linear-gradient(to right,#CFE7F0,#3299be,#5db7d8); color:#FFFFFF;font-size:110%;}
    </style>
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-51676003-1', 'auto');
      ga('send', 'pageview');

    </script>

    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <script>
      (adsbygoogle = window.adsbygoogle || []).push({
        google_ad_client: "{{ config('adsense.data_ad_client') }}",
        enable_page_level_ads: true
      });
    </script>
  </head>

  <body class="{{ $page_type ?? '' }}">
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="{{ url('/') }}" title="{{ ucfirst($post->slug) }} info e prezzi - Informatic Solutions">
            <i class="fas fa-cogs"></i>Informatic-solutions
          </a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav navbar-right">
            <li class="go-comparator">
              <a href="{{ url('/videocitofoni/comparatore-prezzi') }}">Vai al Comparatore</a>
            </li>
            <!--li>
              <a href="#about">About</a>
            </li-->
            <!--li>
              <a href="#contact">Contact</a>
            </li-->
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>


  <!--start content-->
  @yield('cms-content')
  <!--end content-->


  <footer class="footer">
    <div class="container-fluid">
      <p class="text-center first">Informatic-Solutions.it - P.Iva 08497200967 - Tutti i diritti riservati © {{ date('Y') }}</p>
      <p class="text-center small">La duplicazione anche parziale dei contenuti è severamente vietata; le violazioni saranno segnalate alle autorità competenti e perseguite ai termini di legge</p>
    </div>  
  </footer>

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <!--script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script--><!--se non funziona: controllare versione-->
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="{{ url('js/app.js') }}"></script>

  <script src="/artic-rating/ambiance-plugin/jquery.ambiance.js"></script> 
  <script>
    jQuery(document).ready(function () {
      $('#stelle .stars').click(function () {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var postid = '{{$post->id}}';
        $.post('{{ url('articles-rating') }}',
                {_token: CSRF_TOKEN, rate: $(this).val(), post_id: postid },
                function(d){ 
                  //console.log(d);
                  if(d > 0) { // d=id in db(autoincrement))
                    $.ambiance({
                      message: "Hai già votato questo articolo. Un solo voto consentito.",
                      title: "Errore!",
                      type: "error",                    
                    });
                  } else {
                    $.ambiance({
                      message: "Grazie per aver votato questo articolo.",
                      title: "Voto aggiunto!",
                      type: "success",                    
                    });
                    var n = parseInt($('.votes_numb').text())+1;
                    $('.votes_numb').text(n);
                  }
                }),

        $(this).attr("checked");
      });
    });
  </script>
  </body>
</html>