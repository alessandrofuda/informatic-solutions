@extends('layouts.comparator')

@section('content')

<div id="users-list" class="container" style="padding: 0; font-size: 10px;">
    <div class="row">
        <div class="col-md-12 col-md-offset-0">
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                        <h3>Elenco di tutti gli utenti presenti in db</h3>
                </div>
                
                <div class="panel-body">

                		<div class="text-center">
                			{{ $users->links() }} <!--pagination-->
                		</div>

                	<table class="table table-striped">
                		<thead>
                            <td><b>Id</b></td>
                			<td><b>Nome</b></td>
                			<td><b>E-mail</b></td>
                            <td><b>Ruolo</b></td>
                			<td><b>Verificato</b></td>
                			<td><b>Data di registrazione</b></td>
                			<td class="text-center"><b>Oggetti in osservazione</b></td>
                			<!--td><b>Indirizzo IP</b></td-->
                            <td></td>
                		</thead>

                        {{--@if (count($comments) == 0)--}}
                            <!--div class="alert alert-success text-center" role="alert">Non ci sono commenti</div-->
                        {{--@endif--}}
                        

                		@foreach ($users as $user)
                		
                		<tr>
                            <td><b>{{ $user->id }}</b></td>
                			<td>{{ $user->name }}</td>
                			<td>{{ $user->email }}</td>
                			<td>{{ $user->role }}</td>
                            <td>{{ $user->verified ? 'si' : 'no' }}</td>
                			<td>{{ date('d/m/Y - H:i' , strtotime($user->created_at)) }}</td>
                			<td class="text-center">
                                <a href="{{ route('admin.users.show', ['user' => $user->id] ) }}" class="btn btn-primary btn-sm btn-v-space">Vai alla pagina Utente</a>       
                            </td>
                			<!--td class="text-center"> - </td-->
                            <td class="text-center">
                                <a href="{{ route('admin.users.edit', ['user' => $user->id] ) }}" class="btn btn-primary btn-sm btn-v-space">Modifica</a>
                                <form method="post" action="{{ route('admin.users.store', ['user' => $user->id] ) }}">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="_method" value="DELETE" >
                                    <!--input type="hidden" name="id" value="{{ $user->id }}"-->
                                    <input class="btn btn-danger btn-sm btn-v-space" type="submit" name="" value="Elimina" onclick="return confirm('Confermare la cancellazione dell\'utente {{$user->name}}?')">
                                </form>
                                <!--a href="{{-- route('backend/users/'. $user->id) --}}" class="btn btn-danger btn-sm btn-v-space" onclick="return confirm('Confermare la cancellazione dell\'utente {{--$user->name--}}?')">Elimina</a-->
                            </td>

                		</tr>

                		@endforeach

                	</table>

                    <div class="text-center">
                        {{ $users->links() }}
                    </div>

                	<div class="text-center">
                        <a class="btn btn-primary btn-sm" href="{{ route('admin.home') }}">Torna alla dashboard</a>
                	</div>

                </div>
               	</div>
           	</div>
       	</div>
   	</div>
</div>

@endsection