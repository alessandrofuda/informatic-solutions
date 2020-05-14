@extends('layouts.comparator')

@section('content')
<div class="change-profile-wrap">
    <div class="change-profile-row">
        <div class="change-profile">
            <div class="panel panel-default">
                <div class="panel-heading text-center">Modifica Profilo</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="form-horizontal" role="form" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Modifica Nome</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name" value="{{ $user->name ?? null }}" required>
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">Modifica Email</label>
                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" value="{{ $user->email ?? null }}" required>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Aggiorna profilo
                                </button>
                                <a class="btn btn-default" style="float: right;" href="{{url('backend')}}">Indietro</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection