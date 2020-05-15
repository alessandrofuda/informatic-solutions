@extends('layouts.comparator')

@section('content')
    <div id="homepage" class="container-fluid">
        <div class="row first">
            <div class="slider-container" style="background-image: url('{{ asset('images-hp/hp-slide-1.jpg') }}')">
                <div class="slider-overlay"></div>
                <div class="slider-content">
                    <div class="col-sm-4 slider-block">
                        <i class="fas fa-list-alt slide-hp"></i>Confronta<br>Prodotti
                    </div>
                    <div class="col-sm-4 slider-block">
                        <i class="fas fa-chart-line slide-hp"></i><h1>Monitora i <br>Prezzi</h1>
                    </div>
                    <div class="col-sm-4 slider-block">
                        <i class="fas fa-hand-holding-usd slide-hp"></i>Compra e <br>Risparmia
                    </div>
                </div>
            </div>
        </div>
        <div class="row second">
            <div class="col-md-6">
                <div class="block1">
                    <div class="block-title">Leggi le nostre guide</div>
                    <div class="block-body">
                        <ul>
                            {{-- @foreach($articles as $article) --}}
                            <li><a href="{{ url('videocitofoni') }}" title="{{ 'videocitofoni, qualità prezzo' }}">Videocitofoni, come scegliere il miglior rapporto qualità prezzo</a></li>
                            {{-- @endforeach --}}
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="block2">
                    <a class="cta" href="{{ url('videocitofoni/comparatore-prezzi') }}">
                        <span class="block-title">
                            <span class="col-md-10 block-title-1">Vai al comparatore e monitora i prezzi
                                <span class="cta-btn">Scopri come funziona</span>
                            </span>
                            <span class="col-md-2 block-title-2"><i class="fas fa-chevron-right"></i></span>
                        </span>
                    </a>
                </div>
            </div>
        </div>  
    </div>

    <script>
        $(document).ready(function(){
            $('.block2 .cta').hover(function(){
                $('.block2 .cta-btn').css({
                        'text-shadow' : '1px 1px 0px #000',
                        'border' : '1px solid #217aa2'
                    });
            }, function(){
                $('.block2 .cta-btn').css({
                        'text-shadow' : 'none',
                        'border' : 'none'
                    });
            }
            );
        });
    </script>

@endsection

