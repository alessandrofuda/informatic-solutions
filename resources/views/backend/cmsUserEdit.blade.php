@extends('layouts.comparator')

@section('content')

<div id="comment-edit" class="container">
    <div class="row">
        <div class="col-md-12 col-md-offset-0">
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    Modifica utente {{ $user->id }}
                </div>
                
                <div class="panel-body">

                    <form method="POST" action="/backend/users/{{ $user->id }}">
                        
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="PUT">

                    	<table class="table table-striped">
                    	   
                           <tr>
                               <td class="first-col text-right"><label for="id">Id:</label></td>
                               <td>{{ $user->id }}</td>
                           </tr>

                           <tr>
                               <td class="first-col text-right"><label for="name">Nome:</label></td>
                               <td><input type="text" name="name" value="{{ $user->name }}" /></td>
                           </tr>

                           <tr>
                               <td class="first-col text-right"><label for="e-mail">E-mail:</label></td>
                               <td>{{ $user->email }}</td>
                           </tr>

                           @if (Auth::user()->is_admin())
                           <tr>
                               <td class="first-col text-right"><label for="profilo">Profilo:</label></td>
                               <style>
                               		.radio-inline{margin-right: 10px; border-right: 1px solid #CCC; padding-right: 20px;}
                               		.radio-inline input[type="radio"]{margin-top: 2px;}
                               	</style>
                               <td>
                               	
                               	<span class="radio-inline">
                               		<input id="subscriber" name="role" value="subscriber" type="radio" {{ $user->role == 'subscriber' ? 'checked' : '' }}>
                               		Iscritto al servizio
                               	</span>
                               	<span class="radio-inline">
                               		<input id="author" name="role" value="author" type="radio" {{ $user->role == 'author' ? 'checked' : '' }}>
                               		Autore
                               	</span>
                               	<span class="radio-inline">
                               		<input id="admin" name="role" value="admin" type="radio" {{ $user->role == 'admin' ? 'checked' : ''}}>
                               		Amministratore
                               	</span>
                               	
                               </td>
                           </tr>
                           @endif

                           <tr>
                               <td class="first-col text-right"><label for="verified">Email verificata?</label></td>
                               <td>{{ $user->verified ? 'Sì' : '<span style="color:red">No</span>' }}</td>
                           </tr>

                           <tr>
                               <td class="first-col text-right">Utente iscritto dal:</td>
                               <td>{{ $date }}</td>
                           </tr>

                           <tr>
                               <td class="first-col text-right">IP:</td>
                               <td> - </td>
                           </tr>

                           <tr>
                               <td class="first-col text-right"><label for="observed">Prodotti monitorati</label></td>
                               <td> - </td>
                           </tr>

 						   <tr>
                               <td class="first-col text-right"><label for="add">Monitora altri prodotti (cerca)</label></td>
                               <td> - </td>
                           </tr>                    


                           
                        </table>   
                            <div class="text-right text-right">
                                <button class="btn btn-primary btn-sm" type="submit">Salva le modifiche</button>
                                <a class="btn btn-danger btn-sm" href="{{ URL::previous() }}">Torna indietro</a> 
                            </div>   
                               

                    	
                    </form>
                </div>
           	</div>
       	</div>
   	</div>
</div>

@endsection

