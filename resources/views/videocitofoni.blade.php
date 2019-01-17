@extends('layouts.cms')

@section('cms-content')
<section id="section-1" class="container-fluid" role="main" itemscope itemtype="https://schema.org/Article">
  <div id="article-container" class="row">
    <div id="article" class="col-md-10 col-md-offset-1">
      <h1 class="title" itemprop="name">{{$post->title}}</h1>
      <h2 class="sub-title">Tutte le informazioni sui videocitofoni con e senza fili: marche, tipologie, prezzi, qualità e novità sul mercato.</h2>
      <div id="content" class="content">

        {{-- meta --}}
        <div class="postmeta">
          <!--div class="lab">Aggiornato il</div-->  
          <time datetime="2018-01-22{{-- date('Y-m-d') --}}" itemprop="datePublished">22/01/2018{{-- date('d-m-Y') --}}</time>
          <!--div class="lab">Autore</div-->
          - <span itemprop="author">Massimiliano Bossi</span>
        </div>

        @include('partials.cms-rating')

        {{--google adsense--}}          
        <div id="adv1" style="margin: 50px auto 30px; width: 100%; height: 280px; {{ env('ADSENSE_DEV_BORDER', '') }}">
          <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
          <!-- informatic-solutions top rectangle responsive -->
          <ins class="adsbygoogle" style="display: block;" data-ad-client="{{ env('DATA_AD_CLIENT', '') }}" data-ad-slot="{{ env('DATA_AD_SLOT', '') }}" data-ad-format="rectangle"></ins>
          <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
          </script>
        </div>

        <div id="intro" class="row">
          @include('partials.cms-article-intro')
        </div><!--intro-->

        <div id="index" class="row">
          @include('partials.cms-article-index')
        </div><!--#index-->

        <div id="article-content">
          @include('partials.cms-article-content')
        </div>

        <div id="adv2" style="margin: 30px auto; width: 100%; min-height: 250px; {{ env('ADSENSE_DEV_BORDER', '') }}">
          <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
          <ins class="adsbygoogle" style="display: block;" data-ad-client="{{ env('DATA_AD_CLIENT', '') }}" data-ad-slot="{{ env('DATA_AD_SLOT', '') }}" data-ad-format="rectangle"></ins>
          <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
          </script>
        </div><!--#adv2-->
      </div><!--#content-->


      <div id="comments-container">
          @include('partials.cms-article-comments')
      </div>


    </div><!--#article-->
  </div><!--#article-container-->
</section><!--#section-1-->

@endsection
