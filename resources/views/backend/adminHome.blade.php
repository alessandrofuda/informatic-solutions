@extends('layouts.comparator')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-md-offset-0">
            <div class="panel panel-default">
                <h2 class="panel-heading text-center">Dashboard</h2>
                <div class="panel-body">                    
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            ciao <span style="color:red;">{{ ucfirst(Auth::user()->name) }}</span>, sei loggato come <strong>amministratore</strong>.
                        </div>
                        <div class="panel-body">

                            @include('partials.comparator-my-profile')

                            <hr style="margin:80px auto;">

                            <h3 class="title text-center">Funzioni</h3>
                            <div class="admin-buttons-wrap">
                                <a class="btn btn-primary btn-sm" href="{{route('admin.comments')}}">Visualizza tutti i commenti</a>
                                <a class="btn btn-primary btn-sm" href="{{route('admin.pending-comments')}}">Solo commenti in moderazione</a>    
                                <a class="btn btn-primary btn-sm" href="{{route('admin.users.index')}}">Visualizza tutti gli utenti</a>
                                <a class="btn btn-danger btn-sm" href="{{url('admin/log-reader')}}" >Log Applicazione</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
