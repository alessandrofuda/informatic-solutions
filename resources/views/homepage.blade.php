<!DOCTYPE html>
<html lang="en"> {{-- Riportato il tema custom da wp // tutte le cartelle del tema sono in /PUBLIC/CUSTOM/... (informatic-solutions.it/custom/...) --}}

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="alessandro" >

    <title>Informatic Solutions - Soluzioni informatiche personalizzate</title>

    <!-- Bootstrap Core CSS -->
    <link href="custom/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="custom/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>

    <!-- Plugin CSS -->
    <link href="custom/vendor/magnific-popup/magnific-popup.css" rel="stylesheet">

    <!-- Theme CSS -->
    <link href="custom/css/creative.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="custom/css/custom.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!--recaptcha google-->
    <script src='https://www.google.com/recaptcha/api.js'></script>

</head>

<body id="page-top">

    <nav id="mainNav" class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span> Menu <i class="fa fa-bars"></i>
                </button>
                <!--<a class="navbar-brand page-scroll" href="#page-top">Torna su</a>-->
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a class="page-scroll" href="#about">Chi siamo</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#services">Servizi</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#portfolio">Features</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#dove">Dove siamo</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#contact">Contatti e preventivi</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

    <header>
        <div class="header-content">
            <div class="header-content-inner">
                <h1 id="homeHeading"><span class="top-title">Informatic-Solutions</span><span class="occhiello">Soluzioni Informatiche<br/>al servizio della tua impresa</span></h1>
                <hr>
                <p>Acquisire più clienti e aumentare il successo dell'azienda. Come? Creando un'infrastruttura tecnologica avanzata in grado di <span class="rosso">semplificare</span>, <span class="rosso">integrare</span> ed <span class="rosso">ottimizzare</span> tutti i processi aziendali. Affidati a noi.</p>
                <a href="#contact" class="btn btn-primary btn-xl page-scroll"> Richiedi un consulto </a>
            </div>
        </div>
    </header>

    <section class="bg-primary" id="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 text-center">
                    <h2 class="section-heading">Abbiamo quello di cui avete bisogno!</h2>
                    <hr class="light">
                    <p class="text-faded">Informatic-Solutions nasce da un gruppo di professionisti esperti che operano nell’Information Techology. Presente sul mercato dal 2000 ha l'obbiettivo di fidelizzare il cliente garantendo un servizio completo nell'ambito della realizzazione ed implementazione di soluzioni applicative complete.<br/><br/>La struttura integra la forza e la professionalità di un'azienda giovane e dinamica con l'esperienza e la consolidata affidabilità di professionalità mature. Svolgiamo i nostri servizi con particolare attenzione al rapporto col cliente. Studiamo soluzioni personalizzate sia per la piccola che per la media e grande azienda. Con molte di queste manteniamo tutt'oggi ottimi e consolidati rapporti di collaborazione.<br/><br/>Offriamo ai nostri clienti un supporto completo: dalla consulenza, allo sviluppo e vendita di hardware e software personalizzati, dall'installazione all'assistenza tecnica. L'offerta dei nostri servizi di assistenza è molto ampia e si adatta alle esigenze del cliente. Il nostro obbiettivo è quello di garantire sempre un servizio tecnico tempestivo ed efficace.<br/><br/></p>
                    <a href="#contact" class="page-scroll btn btn-default btn-xl sr-button">Contattaci ora!</a>
                </div>
            </div>
        </div>
    </section>

    <section id="services">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">I nostri servizi</h2>
                    <hr class="primary">
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-4x fa-lightbulb-o text-primary sr-icons"></i>
                        <h3>Consulenza</h3>
                        <p class="text-muted">Offriamo un servizio completo di consulenza sistemistica e gestionale, facciamo tutto noi. Tu fai il tuo lavoro.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-4x fa-desktop text-primary sr-icons"></i>
                        <h3>Sviluppo</h3>
                        <p class="text-muted">Sviluppiamo software personalizzato, <a style="color:#775;" href="/videocitofoni/comparatore-prezzi">applicazioni</a> e <a style="color:#775;" href="/videocitofoni">siti web dinamici</a> e adattabili ai dispositivi mobili.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-4x fa-line-chart text-primary sr-icons"></i>
                        <h3>Ottimizzazione</h3>
                        <p class="text-muted">Diminuire gli sforzi per migliorare i risultati. Questo l'obiettivo di ogni intervento. Ottimizzare è la parola d'ordine.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-4x fa-users text-primary sr-icons"></i>
                        <h3>Assistenza</h3>
                        <p class="text-muted">Offriamo assistenza sistemistica di base ed avanzata oltre ad un servizio di HelpDesk sia da remoto sia presso il cliente.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="no-padding" id="portfolio">
        <div class="container-fluid">
            <div class="row no-gutter popup-gallery">
                <div class="col-lg-4 col-sm-6">
                
                    <a href="#slide1" class="portfolio-box open-popup-link">
                        <img src="custom/img/portfolio/thumbnails/1.jpg" class="img-responsive" alt="">
                        <div class="portfolio-box-caption">
                            <div class="portfolio-box-caption-content">
                                <div class="project-category text-faded">
                                    Consulting Security
                                </div>
                                <div class="project-name">
                                    Protezione e gestione della Sicurezza dei dati e dell'Infrastruttura Informatica
                                </div>
                            </div>
                        </div>
                    </a>
                    
                    <div id="slide1" class="inline-popup mfp-hide">
                    			<img src="custom/img/portfolio/thumbnails/1.jpg" class="img-responsive" alt="">
                    			<div class="inline-popup-container">
                    				<div class="inline-popup-content">
                                <div class="inline-popup-title">
                                    Consulting Security
                                </div>
                                <div class="inline-popup-descr">
                                    Protezione e gestione della Sicurezza dei dati e dell'Infrastruttura Informatica
                                </div>
                              </div>
                        	</div>
                    </div>
                    
                    
                                    
                </div>
                <div class="col-lg-4 col-sm-6">
                    <a href="#slide2" class="portfolio-box open-popup-link">
                        <img src="custom/img/portfolio/thumbnails/2.jpg" class="img-responsive" alt="">
                        <div class="portfolio-box-caption">
                            <div class="portfolio-box-caption-content">
                                <div class="project-category text-faded">
                                    Web Developement
                                </div>
                                <div class="project-name">
                                    Sviluppo di Web Application per la gestione documentale, portali e App.
                                </div>
                            </div>
                        </div>
                    </a>
                    
                    <div id="slide2" class="inline-popup mfp-hide">
                    			<img src="custom/img/portfolio/thumbnails/2.jpg" class="img-responsive" alt="">
                    			<div class="inline-popup-container">
                    				<div class="inline-popup-content">
                                <div class="inline-popup-title">
                                    Web Developement
                                </div>
                                <div class="inline-popup-descr">
                                    Sviluppo di Web Application per la gestione documentale, portali e App.
                                </div>
                              </div>
                        	</div>
                    </div>
                    
                </div>
                <div class="col-lg-4 col-sm-6">
                    <a href="#slide3" class="portfolio-box open-popup-link">
                        <img src="custom/img/portfolio/thumbnails/3.jpg" class="img-responsive" alt="">
                        <div class="portfolio-box-caption">
                            <div class="portfolio-box-caption-content">
                                <div class="project-category text-faded">
                                    Infrastructures
                                </div>
                                <div class="project-name">
                                    Virtualizzazione e Cloud. Storage, Backup e Disaster Recovery. Network Configuration.
                                </div>
                            </div>
                        </div>
                    </a>
                    
                    <div id="slide3" class="inline-popup mfp-hide">
                    			<img src="custom/img/portfolio/thumbnails/3.jpg" class="img-responsive" alt="">
                    			<div class="inline-popup-container">
                    				<div class="inline-popup-content">
                                <div class="inline-popup-title">
                                    Infrastructures
                                </div>
                                <div class="inline-popup-descr">
                                    Virtualizzazione e Cloud. Storage, Backup e Disaster Recovery. Network Configuration.
                                </div>
                              </div>
                        	</div>
                    </div>
                    
                </div>
                <div class="col-lg-4 col-sm-6">
                    <a href="#slide4" class="portfolio-box open-popup-link">
                        <img src="custom/img/portfolio/thumbnails/4.jpg" class="img-responsive" alt="">
                        <div class="portfolio-box-caption">
                            <div class="portfolio-box-caption-content">
                                <div class="project-category text-faded">
                                    IT Governance
                                </div>
                                <div class="project-name">
                                    Monitoraggio e Gestione dell'infrastruttura IT. Gestione delle Identità e delle Utenze.
                                </div>
                            </div>
                        </div>
                    </a>
                    
                    <div id="slide4" class="inline-popup mfp-hide">
                    			<img src="custom/img/portfolio/thumbnails/4.jpg" class="img-responsive" alt="">
                    			<div class="inline-popup-container">
                    				<div class="inline-popup-content">
                                <div class="inline-popup-title">
                                    IT Governance
                                </div>
                                <div class="inline-popup-descr">
                                    Monitoraggio e Gestione dell'infrastruttura IT. Gestione delle Identità e delle Utenze.
                                </div>
                              </div>
                        	</div>
                    </div>
                    
                </div>
                <div class="col-lg-4 col-sm-6">
                    <a href="#slide5" class="portfolio-box open-popup-link">
                        <img src="custom/img/portfolio/thumbnails/5.jpg" class="img-responsive" alt="">
                        <div class="portfolio-box-caption">
                            <div class="portfolio-box-caption-content">
                                <div class="project-category text-faded">
                                    CED e Reti Dati
                                </div>
                                <div class="project-name">
                                    Progettazione, realizzazione e manutenzione di reti Wireless, WAN, LAN e armadi dati.
                                </div>
                            </div>
                        </div>
                    </a>
                    
                    <div id="slide5" class="inline-popup mfp-hide">
                    			<img src="custom/img/portfolio/thumbnails/5.jpg" class="img-responsive" alt="">
                    			<div class="inline-popup-container">
                    				<div class="inline-popup-content">
                                <div class="inline-popup-title">
                                    CED e Reti Dati
                                </div>
                                <div class="inline-popup-descr">
                                    Progettazione, realizzazione e manutenzione di reti Wireless, WAN, LAN e armadi dati.
                                </div>
                              </div>
                        	</div>
                    </div>
                    
                </div>
                <div class="col-lg-4 col-sm-6">
                    <a href="#slide6" class="portfolio-box open-popup-link">
                        <img src="custom/img/portfolio/thumbnails/6.jpg" class="img-responsive" alt="">
                        <div class="portfolio-box-caption">
                            <div class="portfolio-box-caption-content">
                                <div class="project-category text-faded">
                                    Data Management e Data Integration
                                </div>
                                <div class="project-name">
                                    Implementazione di sistemi di gestione integrata dei dati anche attraverso Virtual Private Network.
                                </div>
                            </div>
                        </div>
                    </a>
                    
                    <div id="slide6" class="inline-popup mfp-hide">
                    			<img src="custom/img/portfolio/thumbnails/6.jpg" class="img-responsive" alt="">
                    			<div class="inline-popup-container">
                    				<div class="inline-popup-content">
                                <div class="inline-popup-title">
                                    Data Management e Data Integration
                                </div>
                                <div class="inline-popup-descr">
                                    Implementazione di sistemi di gestione integrata dei dati anche attraverso Virtual Private Network.
                                </div>
                              </div>
                        	</div>
                    </div>
                    
                </div>
            </div>
        </div>
    </section>

    <aside class="bg-dark">
        <div class="container text-center">
            <div class="call-to-action">
                <h2>Inizia ora, scopri le nostre soluzioni tecnologiche per la tua impresa!<br/><br/></h2>
                <a href="#contact" class="btn btn-default btn-xl sr-button">Contattaci ora!</a>
            </div>
        </div>
    </aside>
    
    <section id="dove">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                    <h2 class="section-heading">Dove siamo</h2>
                    <hr class="primary">
                    <p>Tigne Place, Block 10, Tigne Street, Sliema SLM 3171, Malta</p>
                    <p><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3231.5221499647355!2d14.505178950381081!3d35.90971732491798!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x130e4524d29523e7%3A0x3d8965161e51c3a!2sOasis+Offices!5e0!3m2!1sit!2sit!4v1475594667980" width="100%" height="500" frameborder="0" style="border:0" allowfullscreen></iframe></p>
                </div>
            </div>
        </div>
    </section><!--#dove-->

    <section id="contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 text-center">
                    <h2 class="section-heading">Richiedi subito il nostro consulto!</h2>
                    <hr class="primary">
                    <p>Progettiamo insieme la tua nuova infrastruttura! Iniziamo subito. Compila il form qui sotto. Ti contatteremo per valutare insieme le tue esigenze e le nostre proposte.</p>
                </div>
                <div class="col-lg-4 col-lg-offset-2 text-center">
                    <i class="fa fa-phone fa-3x sr-contact"></i>
                    <p>+356 2135-1080</p>
                </div>
                <div class="col-lg-4 text-center">
                    <i class="fa fa-envelope-o fa-3x sr-contact"></i>
                    <p><a href="mailto:info@informatic-solutions.it">info@informatic-solutions.it</a></p>
                </div>
            </div>
            <div class="row form">
            	<div class="col-lg-10 col-lg-offset-1 text-center">
            	
            	<!--start form-->
<form id="form" role="form" class="form" method="post" action="#result">

    {{ csrf_field() }}

    <div class="row">

    	<div class="col-md-6">
    		<section id="module_3" class="input-group module"><span class="input-group-addon" style="border-radius: 4px;"><i class="fa fa-user" style="font-size: 14px !important;"></i></span>
    		<input required="required" placeholder="Nome"  name="nome" data-validation="length" data-validation-length="max50" data-validation-error-msg="Inserisci il nome (max 50 caratteri)" class="form-control" style="font-size: 14px; border-radius: 4px;" type="text" value="{{ old('nome') }}">
    		</section>	
       </div>
       
       <div class="col-md-6">
    		<section id="module_22" class="input-group module"><span class="input-group-addon"><i class="fa fa-user"></i></span><input required="required" placeholder="Cognome" name="cognome" data-validation="length" data-validation-length="max50" data-validation-error-msg="Inserisci il cognome (max 50 caratteri)" class="form-control" type="text" value="{{ old('cognome') }}">
    		</section>
    	</div>
    	
    </div><!--.row-->	


    <div class="row">

    	<div class="col-md-6">
    		<section id="module_2" class="input-group module"><span class="input-group-addon" style="border-radius: 4px;"><i class="fa fa-envelope-o" style="font-size: 14px !important;"></i></span><input name="email" data-validation="email" data-validation-error-msg="Inserisci un indirizzo e-mail corretto" class="form-control" placeholder="E-mail" style="font-size: 14px; border-radius: 4px;" type="text" value="{{ old('email') }}">
    		</section>
       </div>
       
    	<div class="col-md-6">
            <section id="module_17" class="input-group module"><span class="input-group-addon"><i class="fa fa-phone"></i></span><input name="phone" data-validation="custom" data-validation-regexp="^([0-9\+ ]{5,35})$" data-validation-error-msg="Inserisci il numero di telefono (solo numeri e '+', max 30 caratteri)" class="form-control" placeholder="Telefono" type="text" value="{{ old('phone') }}">
            </section>
    	</div>
    	
    </div><!--.row-->


    <div class="row">

    	<div class="col-md-12">
            <section id="module_4" class="input-group module"><span class="input-group-addon" style="border-radius: 4px;"><i class="fa fa-laptop" style="font-size: 14px !important;"></i></span><input name="sito-web" data-validation="length" data-validation-length="max40" data-validation-error-msg="Inserisci un indirizzo corretto o lascia bianco (max 40 caratteri)" class="form-control" placeholder="Inserisci il tuo sito web (se lo hai)" style="font-size: 14px; border-radius: 4px;" type="text" value="{{ old('sito-web') }}">
            </section>
       </div> <!--data-validation="url" -->
       
    </div><!--.row-->


    <div class="row">

    <div class="col-md-4">

            <section id="module_5" class="input-group module">
                <span class="input-group-addon" style="border-radius: 4px;"><i class="fa fa-check" style="font-size: 14px !important;"></i></span>
                <select name="come-mi-hai-trovato" required="required" data-validation="" data-validation-error-msg="Scegli una di queste opzioni" class="form-control" style="font-size: 14px; border-radius: 4px;">
                    <option selected="" disabled="" value="null">Come ci hai trovato</option>
                    <option value="Motori di ricerca">Motori di ricerca</option>
                    <option value="Link da altri siti">Link da altri siti</option>
                    <option value="Pubblicita">Pubblicità</option>
                    <option value="Ti hanno parlato di noi">Ti hanno parlato di noi</option>
                    <option value="Altro">Altro</option>
                </select>
            </section>
    	</div><!--.col-md-4-->
    	
    	<div class="col-md-4">

            <section id="module_6" class="input-group module">
                <span class="input-group-addon" style="border-radius: 4px;"><i class="fa fa-check" style="font-size: 14px !important;"></i></span>
                <select name="servizio-richiesto" required="required" data-validation="" data-validation-error-msg="Scegli un servizio" class="form-control" style="font-size: 14px; border-radius: 4px;">
                    <option selected="" disabled="" value="null">Servizio Richiesto</option>
                    <option value="Sviluppo Web">Sviluppo Web</option>
                    <option value="Creaz-ottimizzazione Infrastruttura">Creazione/Ottimizzazione Infrastruttura</option>
                    <option value="IT Consulting">IT Consulting</option>
                    <option value="Altro">Altro</option>
                </select>
            </section>
            
            </div><!--.col-md-4-->
            
    	<div class="col-md-4">

            <section id="module_7" class="input-group module">
                <span class="input-group-addon" style="border-radius: 4px;"><i class="fa fa-check" style="font-size: 14px !important;"></i></span>
                <select name="budget" required="required" data-validation="" data-validation-error-msg="Scegli il tipo di profilo/budget" class="form-control" style="font-size: 14px; border-radius: 4px;">
                    <option selected="" disabled="" value="null">Indica il profilo in base al budget</option>
                     <option value="Professional">Professional</option>
                      <option value="Business">Business</option>
                    <option value="Basic">Basic</option>               
               </select>
            </section>
            
    	</div><!--.col-md-4-->
            
    </div><!--.row-->

    <div class="row">
    	<div class="col-md-12">

            <section id="module_14" class="input-group module">
                <textarea name="messaggio" data-validation="length" data-validation-length="max800" data-validation-error-msg="Messaggio troppo lungo. Massimo 800 caratteri." class="form-control" placeholder="Anticipa qui le tue necessità, tua richiesta, la tua idea o il tuo progetto.." style="font-size: 14px; border-radius: 4px;">{{ old('messaggio') }}</textarea>
            </section>
            <div class="privacy"><a href="#">Informativa privacy</a></div>
       </div><!--.col-md-12-->
            
    </div><!--.row-->

    <div class="row">
        <div class="col-md-12">
            <div class="g-recaptcha" style="display: inline-block;" data-sitekey="{{ env('RE_CAP_SITE') }}"></div>
        </div>
    </div>
        
    <div class="row">
    	<div class="col-md-12">
            <section id="form_submit" class="input-group module">
                <button class="btn btn-lg btn-block btn-danger" data-loading-text="Sending ..." autocomplete="off" type="submit" name="submit" style="font-size: 18px;">Invia messaggio</button>
            </section>
       </div><!--.col-md-12-->
    </div><!--.row-->


	<!--thank-you message-->
	<div id="result" class="form-group">

        @if(Session::has('error_message'))
                <div class="alert alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <center>{!! Session::get('error_message') !!}</center>
            </div>
        @endif


        @if(Session::has('success_message'))
            <div class="alert alert-success" role="alert">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <center>{!! Session::get('success_message') !!}</center>
            </div>
        @endif

	</div>


    @if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
      

</form><!--end form-->	
            	
            	</div>
            </div>
        </div>
    </section>
    
    <footer> Created by <a href="http://alessandrofuda.it" style="text-decoration: none;">Alessandro Fuda  - Freelance Web Developer</a></footer>

    <!-- jQuery -->
    <script src="custom/vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="custom/vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
    <script src="custom/vendor/scrollreveal/scrollreveal.min.js"></script>
    <script src="custom/vendor/magnific-popup/jquery.magnific-popup.min.js"></script>

    <!-- Theme JavaScript -->
    <script src="custom/js/creative.js"></script>
    
    <!-- Plugin jQuery form validator -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
    <script>
  		$.validate({
    		modules : 'html5'
  		});
	 </script>

</body>

</html> 