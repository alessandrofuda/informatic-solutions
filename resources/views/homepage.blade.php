@extends('layouts.app')

@section('content')
    <div id="homepage" class="container-fluid homepage">
        <div class="row first">
            <div class="slider-container" style="background-image: url('{{ asset('images-hp/hp-slide-1.jpg') }}')">
                <div class="slider-content">
                    <div class="col-md-4">
                        <i class="fas fa-list-alt"></i>Confronta
                    </div>
                    <div class="col-md-4">
                        <i class="fas fa-chart-line "></i>Monitora i Prezzi
                    </div>
                    <div class="col-md-4">
                        <i class="fas fa-hand-holding-usd"></i>Risparmia
                    </div>
                </div>
            </div>
        </div>
        <div class="row second">
            <div class="col-md-6">
                <div class="block1">
                    Leggi le nostre guide
                </div>
            </div>
            <div class="col-md-6">
                <div class="block2">
                    <div class="go-to">Vai al comparatore e monitora i prezzi</div>
                    <div class="cta">Scopri come funziona</div>
                </div>
            </div>
        </div>  
    </div>

@endsection

