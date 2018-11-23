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
                <a class="cta" href="{{ url('videocitofoni/comparatore-prezzi') }}">
                <div class="block2">
                    <span class="block-title">
                        Vai al comparatore e monitora i prezzi
                        Scopri come funziona
                    </span>
                </div>
                </a>
            </div>
        </div>  
    </div>

@endsection

