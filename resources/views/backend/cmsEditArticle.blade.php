@extends('layouts.comparator')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-md-offset-0">
            <div class="panel panel-default">
                <div class="panel-heading text-center">Modifica articolo {{$article->id}}</div>
                <div class="panel-body">                    
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            ciao <span style="color:red;">{{ ucfirst(Auth::user()->name) }}</span>, sei loggato come <strong>autore</strong>.
                        </div>
                        <div class="panel-body">
                            @include('partials.cms-edit-article')
                        </div>
                    </div>
                </div>
            </div>            
        </div>
    </div>
</div>
@endsection
