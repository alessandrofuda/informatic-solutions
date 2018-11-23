@extends('layouts.app')

@section('content')
    <div id="homepage" class="container-fluid homepage">
        <div class="row first">
            <div class="slider-container" style="background-image: url('{{ asset('images-hp/hp-slide-1.jpg') }}')">
                <div class="slider-overlay"></div>
                <div class="slider-content">
                    <div class="col-md-4">
                        <i class="fas fa-list-alt slide-hp"></i>Confronta
                    </div>
                    <div class="col-md-4">
                        <i class="fas fa-chart-line slide-hp"></i>Monitora i Prezzi
                    </div>
                    <div class="col-md-4">
                        <i class="fas fa-hand-holding-usd slide-hp"></i>Risparmia
                    </div>
                </div>
            </div>
        </div>
        <div class="row second">
            <div class="col-md-6">
                <div class="block1">
                    <div class="block-title">Leggi le nostre guide</div> 
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
                        'border' : '1px solid #000'
                    });
            }, function(){
                $('.block2 .cta-btn').css({
                        'text-shadow' : 'inherit',
                        'border' : 'inherit'
                    });
            }
            );
        });
    </script>

@endsection

