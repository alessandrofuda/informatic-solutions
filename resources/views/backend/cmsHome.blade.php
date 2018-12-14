@extends('layouts.comparator')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-md-offset-0">
            <div class="panel panel-default">
                <div class="panel-heading text-center">I tuoi articoli</div>
                <div class="panel-body">                    
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            ciao <span style="color:red;">{{ ucfirst(Auth::user()->name) }}</span>, sei loggato come <strong>autore</strong>.
                        </div>
                        <div class="panel-body">


                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a data-toggle="tab" href="#view-article">Visualizza tutti i tuoi articoli</a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#write-article">Scrivi un nuovo articolo</a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#menu3">Menu 3</a>
                                </li>
                            </ul>


                            <div class="tab-content">
                                <div id="view-article" class="tab-pane fade in active">
                                    @include('partials.cms-show-my-articles')
                                </div>
                                <div id="write-article" class="tab-pane fade">
                                    @include('partials.cms-write-new-article')
                                </div>
                                <div id="menu3" class="tab-pane fade">
                                    <h3>Menu 3</h3>
                                    <p>Some content</p>
                                </div>
                            </div>




                        </div>
                    </div>
                </div>
            </div>            
        </div>
    </div>
</div>
@endsection
